<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;

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
            $validatedData = $request->validate([
                'product' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'weight' => 'nullable|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string',
                'ribbon' => 'nullable|string|max:100',
            ]);

            if ($request->hasFile('image')) {
                $images = $request->file('image');
                $image = $images[0];
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('product_images'), $imageName);
                $validatedData['image'] = 'product_images/' . $imageName;
            }

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
            return view('admin.addProduct', compact('editProduct'));
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
                'price' => 'required|numeric|min:0',
                'weight' => 'nullable|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string',
                'ribbon' => 'nullable|string|max:100',
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('product_images'), $imageName);
                $validatedData['image'] = 'product_images/' . $imageName;
            }

            $product->update($validatedData);

            return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
