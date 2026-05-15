<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    // Relasi Many-to-Many ke tabel Photos
    public function photos()
    {
        return $this->belongsToMany(Photo::class);
    }
}
