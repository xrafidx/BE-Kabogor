<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
