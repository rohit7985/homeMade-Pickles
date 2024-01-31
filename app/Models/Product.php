<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product',
        'price',
        'weight',
        'quantity',
        'image',
        'description',
        'ribbon',
    ];


    public static function getAllProducts()
    {
        return self::orderBy('created_at', 'desc')->paginate(6);
    }

    public function ratingReviews()
    {
        return $this->hasMany(RatingReview::class, 'order_product_id');
    }

    public static function getShowProducts()
    {
        return self::where('hidden', false)->orderBy('created_at', 'desc')->paginate(6);
    }

    public static function getRandomProducts()
    {
        return self::where('hidden', false)->inRandomOrder()->get();
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

}
