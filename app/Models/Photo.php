<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'category_id',    // Wajib ada untuk relasi kategori
        'title', 
        'description', 
        'price', 
        'file_path',       // Lokasi penyimpanan file fisik
        'file_original', 
        'file_watermark', 
        'status'
    ];

    /**
     * Relasi: Satu foto diunggah oleh satu User (Kontributor)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Satu foto memiliki satu Kategori utama
     * (Digunakan jika Anda menggunakan category_id di tabel photos)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi Many-to-Many ke tabel Categories
     * (Pertahankan jika satu foto bisa memiliki banyak label kategori sekaligus)
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Relasi: Satu foto bisa muncul di banyak catatan transaksi
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}