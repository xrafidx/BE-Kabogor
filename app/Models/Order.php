<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'total_price',
    ];

    /**
     * 2. TAMBAHKAN INI: OTOmatis CASTING ke Enum
     * Ini memberi tahu Laravel untuk memperlakukan kolom 'status'
     * sebagai objek OrderStatus, bukan string biasa.
     */
    protected $casts = [
        'status' => OrderStatus::class,
    ];

    /**
     * Mendapatkan user yang memiliki order ini. (Relasi BelongsTo)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendapatkan semua produk yang ada di dalam order ini. (Relasi BelongsToMany)
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product')
                    ->withPivot('quantity', 'price_at_time'); // <-- Ambil data pivot
    }
}
