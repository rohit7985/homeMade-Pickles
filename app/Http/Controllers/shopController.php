<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class shopController extends Controller
{
    public function index()
    {
        try {
            $products = Product::getShowProducts();
            $categories = Category::withCount('products')->get();
            return view('shop', compact('products', 'categories'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function filterByCategory(Category $category)
    {
        try {
            $products = $category->products()
                ->where('hidden', false)
                ->orderBy('created_at', 'desc')
                ->paginate(6);
            $categories = Category::withCount('products')->get();
            return view('shop', compact('products', 'categories'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function filterByPrice(Request $request)
    {
        try {
            $priceRange = $request->input('rangeInput');
            $products = Product::where('price', '<=', $priceRange)
                ->orderBy('created_at', 'desc')
                ->paginate(6)->appends($request->except('page'));
            $request->flash();
            $categories = Category::withCount('products')->get();
            return view('shop', compact('products', 'categories'));
        } catch (\Exception $e) {
            dd($e);
        }
    }




    public function productDetails(Product $product)
    {
        try {
            $products = Product::getRandomProducts();
            $categories = Category::withCount('products')->get();
            return view('productDetails', compact('product', 'products', 'categories'));
        } catch (\Exception $e) {
            dd($e);
        }
    }


    public function viewLogin()
    {
        try {
            return view('login');
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
