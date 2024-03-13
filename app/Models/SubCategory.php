<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_categories';
    use HasFactory;
    protected $fillable = ['category_id', 'sub_category','merchant_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
