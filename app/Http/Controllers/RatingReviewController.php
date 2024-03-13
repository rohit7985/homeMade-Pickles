<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RatingReview;

class RatingReviewController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'orderId' => 'required|exists:orders,id',
                'productId' => 'required|exists:products,id',
                'rating' => 'required|integer|min:1|max:5',
                'description' => 'nullable|string|max:255',
            ]);

            $orderId = $request->input('orderId');
            $productId = $request->input('productId');
            $rating = $request->input('rating');
            $review = $request->input('description');

            // Check if the combination of orderId and productId exists in RatingReview
            $existingRatingReview = RatingReview::where('order_id', $orderId)
                ->where('order_product_id', $productId)
                ->exists();

            if ($existingRatingReview) {
                return redirect()->route('customer.myOrder')->with('error', 'Rating for this product already exists.');
            }


            $ratingReview = new RatingReview();
            $ratingReview->order_id = $orderId;
            $ratingReview->order_product_id = $productId;
            $ratingReview->rating = $rating;
            $ratingReview->review = $review;
            $ratingReview->save();
            return redirect()->route('customer.myOrder')->with('success', 'Thank You for your review');
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
