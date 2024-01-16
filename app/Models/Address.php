<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Add user_id to fillable attributes
        'name',
        'mobile_num',
        'pincode',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
