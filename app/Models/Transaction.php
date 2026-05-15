<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Kolom apa saja yang boleh diisi secara massal
    protected $fillable = [
        'user_id',
        'photo_id',
        'amount',
        'payment_status',
    ];

    // Transaksi ini milik seorang Pembeli (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Transaksi ini membeli sebuah Foto
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
}