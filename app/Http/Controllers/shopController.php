<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class shopController extends Controller
{
    public function index()
    {
        try {
            $products = Product::where('hidden', false)->orderBy('created_at', 'desc')->paginate(6);
            return view('shop', compact('products'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function productDetails(Product $product)
    {
        try {
            return view('productDetails', compact('product'));
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
