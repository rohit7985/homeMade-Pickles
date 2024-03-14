<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\merchantDetails;


class merchant extends  AuthenticatableUser implements Authenticatable

{
    use HasFactory;
    protected $fillable = [
        'shopName','email','google_id'
    ];

    public function merchant()
    {
        return $this->hasOne(merchantDetails::class);
    }
}
