<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingReview extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'order_product_id', 'rating', 'review'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderProductDetail()
    {
        return $this->belongsTo(Product::class);
    }
}
