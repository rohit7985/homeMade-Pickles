<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_amount',
        'status',
        'details',
    ];

    public function ratingReviews()
    {
        return $this->hasMany(RatingReview::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function getOrderDetailsAttribute()
    {
        $order_id = $this->attributes['id'];
        $detail = json_decode($this->attributes['details']);
        $productDetails = [];
    
        if ($detail) {
            $product = Product::find($detail->product_id);
            $rating = RatingReview::where('order_id', $order_id)
                ->where('order_product_id', $detail->product_id)
                ->first();
    
            if ($product) {
                $productDetails[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->product,
                    'price' => $product->price,
                    'image' => $product->image,
                    'quantity' => $detail->quantity,
                    'rating' => $rating->rating ?? '',
                    'review' => $rating->review ?? '',
                ];
            }
        }
    
        return $productDetails;
    }
    
}
