<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::with('ratingReviews')
                ->orderBy('created_at', 'desc')
                ->paginate(6);

            foreach ($products as $product) {
                $averageRating = $product->ratingReviews->avg('rating');
                $product->averageRating = $averageRating;
            }

            return view('admin.products', compact('products'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function addProduct()
    {
        try {
            $categories = Category::all();
            return view('admin.addProduct', compact('categories'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function getSubcategories($categoryId)
    {
        try {
            $subcategories = SubCategory::where('category_id', $categoryId)->get();
            return response()->json($subcategories);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function productSearch(Request $request)
    {
        try {
            $name = $request->searchInput;
            $products = Product::where('product', 'like', '%' . $name . '%')->where('hidden', false)->orderBy('created_at', 'desc')->paginate(6);
            return view('home', compact('products'));
        } catch (\Exception $e) {
            // Handle the exception, log it, or return an error response
            return response()->json(['error' => 'An error occurred while processing the search.' . $e], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $query = $request->input('query');

            // Perform a search query on your Product model
            $results = Product::where('product', 'like', '%' . $query . '%')->limit(5)->get();
            return response()->json($results);
        } catch (\Exception $e) {
            // Handle the exception, log it, or return an error response
            return response()->json(['error' => 'An error occurred while processing the search.' . $e], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'product' => 'required|string|max:255',
                'category' => 'required|exists:categories,id', 
                'subcategory' => 'required|exists:sub_categories,id',
                'price' => 'required|numeric|min:0',
                'weight' => 'nullable|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string',
                'ribbon' => 'nullable|string|max:100',
            ]);

            $merchantId = Auth::user()->id;
            $validatedData['merchant_id'] = $merchantId;



            if ($request->hasFile('image')) {
                $images = $request->file('image');
                $image = $images[0];
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('product_images'), $imageName);
                $validatedData['image'] = 'product_images/' . $imageName;
            }
            $validatedData['category_id'] = intval($validatedData['category'], 10);
            $validatedData['subcategory_id'] = intval($validatedData['subcategory'], 10);
            unset($validatedData['category'], $validatedData['subcategory']);
            $product = Product::create($validatedData);
            $data = [];
            if ($product) {
                // Store additional images in the product_images table
                for ($i = 1; $i < count($images); $i++) {
                    $image = $images[$i];
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('product_images'), $imageName);
                    $data['image'] = 'product_images/' . $imageName;

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $data['image'],
                    ]);
                }
            }
            return redirect()->route('admin.products')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function destroy(Request $request, Product $product)
    {
        try {

            $product->delete();

            if ($request->ajax()) {
                return response()->json(['success' => 'Product deleted successfully!']);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function edit(Product $editProduct)
    {
        try {
            $categories = Category::all();
            $subcategories = SubCategory::all();
            return view('admin.addProduct', compact('editProduct', 'categories', 'subcategories'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function toggleHiddenStatus($id)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                $product->hidden = !$product->hidden;
                $product->save();
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false], 404);
        } catch (\Exception $e) {
            dd($e);
        }
    }


    public function updateQuantity(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $newQuantity = $request->input('new_quantity');
            $from = $request->input('from');
            if ($from == 'Admin') {
                $product = Product::findOrFail($productId);
                $product->quantity = $newQuantity;
                $product->save();
                return response()->json(['updatedQuantity' => $product->quantity]);
            } else {
                $product = Cart::findOrFail($productId);
                $product->quantity = $newQuantity;
                $product->save();
                return response()->json(['updatedQuantity' => $product->quantity]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function update(Request $request, Product $product)
    {
        try {
            $validatedData = $request->validate([
                'product' => 'required|string|max:255',
                'category' => 'required|exists:categories,id',
                'subcategory' => 'required|exists:sub_categories,id',
                'price' => 'required|numeric|min:0',
                'weight' => 'nullable|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string',
                'ribbon' => 'nullable|string|max:100',
            ]);
            // Handle file upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('product_images'), $imageName);
                $validatedData['image'] = 'product_images/' . $imageName;
            } else {
                // If no new image is provided, keep the existing image
                unset($validatedData['image']);
            }
            // dd($validatedData['category'],$validatedData['subcategory']);
            $validatedData['category_id'] = intval($validatedData['category'], 10);
            $validatedData['subcategory_id'] = intval($validatedData['subcategory'], 10);
            unset($validatedData['category'], $validatedData['subcategory']);
            // dd($validatedData);
            $product->update($validatedData);

            return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            // Handle exception
            dd($e);
        }
    }
}
