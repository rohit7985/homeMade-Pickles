<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        try {
            $wishlistItems = Wishlist::with('product')->where('user_id', auth()->user()->id)->get();
            return view('customer.wishlist', compact('wishlistItems'));
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function removeFromWishlist($id)
    {
        Wishlist::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Product removed from wishlist successfully.');
    }

    public function addToWishlist(Request $request)
    {
        try {
            $user = Auth::user();
            $productId = $request->input('productId');

            $item =  Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId
            ]);
            if ($item) {
                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
