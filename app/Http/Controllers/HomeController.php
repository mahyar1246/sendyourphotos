<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tangkap kata kunci pencarian dan filter kategori
        $search = $request->search;
        $category = $request->category;

        // 2. Mulai Query Foto dengan Relasi User (agar nama kreator muncul)
        $photos = \App\Models\Photo::with('user')
            // Filter Pencarian Teks (Cari di Judul atau Deskripsi)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            // Filter Kategori (Jika user klik tombol kategori)
            ->when($category, function ($query, $category) {
                return $query->where('category_id', $category);
            })
            ->latest()
            ->get();

        // 3. Kirim hasil foto ke halaman welcome
        return view('pages.welcome', compact('photos')); // SUDAH DIUPDATE
    }

    // --- FUNGSI BARU UNTUK HALAMAN DETAIL FOTO ---
    public function show($id)
    {
        // Mencari foto di database berdasarkan ID. 
        $photo = Photo::findOrFail($id);
        
        // Melempar data foto spesifik tersebut ke file tampilan bernama 'show'
        return view('photo.show', compact('photo')); // SUDAH DIUPDATE
    }

    public function creatorProfile($id)
    {
        // Ambil data kreator beserta jumlah fotonya
        $creator = \App\Models\User::withCount('photos')->findOrFail($id);
        
        // Ambil semua foto milik kreator tersebut
        $photos = \App\Models\Photo::where('user_id', $id)->latest()->get();

        return view('pages.creator', compact('creator', 'photos')); // SUDAH DIUPDATE
    }

    public function setTheme(Request $request)
    {
        $theme = $request->theme;
        // Kita batasi hanya 3 pilihan agar aman
        if (in_array($theme, ['autumn', 'forest', 'ocean'])) {
            session(['user_theme' => $theme]);
        }
        return back();
    }
}