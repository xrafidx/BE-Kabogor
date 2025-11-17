<?php

namespace App\Enums;

/**
 * Enum ini mendefinisikan nilai-nilai yang mungkin
 * untuk kolom 'status' di tabel 'orders'.
 * Menggunakan string-backed agar nilainya jelas di database.
 */
enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing'; // Ini untuk "in progress"
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
}