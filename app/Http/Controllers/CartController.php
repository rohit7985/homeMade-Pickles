<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function showUserCart()
    {
        try {
            $user = Auth::user();
            if ($user) {
                $cartItems = Cart::with('product')->where('user_id', $user->id)->get();
                // dd($cartItems);
                return view('cart', compact('cartItems'));
            } else {
                return redirect()->route('login.view')->with('error', 'Please login to view your cart.');
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function addToCart(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user) {
                $productId = $request->input('product_id');
                $productName = $request->input('product_name');
                $productPrice = $request->input('product_price');
                $quantity = $request->input('quantity', 1);

                // Check if the product already exists in the user's cart
                $existingCartItem = Cart::where('user_id', $user->id)
                    ->where('product_id', $productId)
                    ->first();
                if ($existingCartItem) {
                    // Update quantity if the product already exists in the cart
                    $existingCartItem->quantity += $quantity;
                    $existingCartItem->save();
                } else {
                    // Add a new item to the cart
                    Cart::create([
                        'user_id' => $user->id,
                        'product_id' => $productId,
                        'product_name' => $productName,
                        'product_price' => $productPrice,
                        'quantity' => $quantity,
                    ]);
                }

                return redirect()->route('customer.cart')->with('success', 'Product added to cart successfully.');
            } else {
                return redirect()->route('login.view')->with('error', 'Please login to add products to your cart.');
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function delete($item) {
        try {
            // Find the cart item by ID and delete it
            $cartItem = Cart::findOrFail($item);
            $cartItem->delete();
    
            return redirect()->back()->with('success', 'Cart item deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete cart item');
        }
    }
    
}
