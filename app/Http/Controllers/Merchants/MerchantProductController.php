<?php

namespace App\Http\Controllers\Merchants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;

class MerchantProductController extends Controller
{
    public function addProduct()
    {
        try {
            $categories = Category::all();
            return view('merchant.addProduct', compact('categories'));
        } catch (\Exception $e) {
            dd($e);
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
            return redirect()->route('merchant.products')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function filterProducts(Request $request)
    {
        try {
            $request->validate([
                'visibility' => 'nullable|boolean',
                'product' => 'nullable|string',
                'priceRange' => 'nullable|numeric', 
            ]);
            $visibility = $request->input('visibility');
            $product = $request->input('product');
            $priceRange = $request->input('priceRange');
            $productQuery = Product::orderBy('created_at', 'desc');
            // Apply filters based on validated input
            if (!is_null($visibility)) {
                $productQuery->where('hidden', $visibility);
            }
    
            if (!is_null($product)) {
                $productQuery->where('product', 'like', '%' . $product . '%');
            }
    
            if (!is_null($priceRange)) {
                $productQuery->where('price', '<=', $priceRange);
            }
    
            // Paginate results
            $products = $productQuery->paginate(10)->appends($request->except('page'));
            $request->flash();
    
            return view('merchant.products', compact('products'));
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while filtering products. Please try again later.');
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

    public function getSubcategories($categoryId)
    {
        try {
            // dd($categoryId);
            $merchant_id = Auth::user()->id;
            $subcategories = SubCategory::where('merchant_id', $merchant_id)->where('category_id', $categoryId)->get();
            return response()->json($subcategories);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function edit(Product $editProduct)
    {
        try {
            $categories = Category::all();
            $subcategories = SubCategory::all();
            return view('merchant.addProduct', compact('editProduct', 'categories', 'subcategories'));
        } catch (\Exception $e) {
            dd($e);
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
            $validatedData['merchant_id'] = Auth::user()->id;
            $product->update($validatedData);

            return redirect()->route('merchant.products')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            // Handle exception
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

    public function updateQuantity(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $newQuantity = $request->input('new_quantity');
            $from = $request->input('from');
            if ($from == 'Merchant') {
                $product = Product::findOrFail($productId);
                $product->quantity = $newQuantity;
                $product->save();
                return response()->json(['updatedQuantity' => $product->quantity]);
            }else{
                return response()->json(['error' => 'Something went wrong']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
