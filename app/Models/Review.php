<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $fillable = [
        'product',
        'product_rating',
        'review',
        'user_id',
        'state'
    ];
}
