<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo; // Memanggil model Photo
use Illuminate\Support\Facades\Auth; // Memanggil fitur Autentikasi
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    // Fungsi untuk menampilkan halaman form upload
    public function create()
    {
        return view('photo.upload');
    }

    // Fungsi untuk memproses data saat tombol "Publish Photo" ditekan
    public function store(Request $request)
    {
        // 1. Validasi Input dari Form
        // Pastikan format file benar dan ukurannya aman (Maks 10MB)
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'price'       => 'required|numeric|min:0',
            'photo'       => 'required|image|mimes:jpeg,png,jpg|max:10240', 
        ]);

        // 2. Simpan File Fisik ke Storage (Folder: storage/app/public/photos)
        // Laravel akan otomatis membuatkan nama file acak yang unik (misal: aksjdh8723.jpg)
        $path = $request->file('photo')->store('photos', 'public');

        // 3. Simpan Data Teks ke Database (Tabel 'photos')
        Photo::create([
            'user_id'     => Auth::id(), // Mengambil ID user yang sedang login saat ini
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'file_path'   => $path, // Menyimpan lokasi path foto tersebut
        ]);

        // 4. Arahkan kembali ke Dashboard dan berikan notifikasi sukses
        return redirect()->route('dashboard')->with('success', 'Karya foto Anda berhasil dipublikasikan!');
    }

    // Fungsi untuk menghapus foto
    public function destroy($id)
    {
        // 1. Cari data foto berdasarkan ID
        $photo = \App\Models\Photo::findOrFail($id);

        // 2. Keamanan: Pastikan yang menghapus adalah pemilik foto itu sendiri
        if ($photo->user_id !== auth()->id()) {
            return back()->with('error', 'Anda tidak diizinkan menghapus foto ini.');
        }

        // 3. Hapus file fisik (gambar asli) dari folder storage agar tidak menumpuk
        if ($photo->file_path && \Storage::disk('public')->exists($photo->file_path)) {
            \Storage::disk('public')->delete($photo->file_path);
        }

        // 4. Hapus data dari database
        $photo->delete();

        // 5. Kembali ke Dashboard dengan pesan sukses
        return back()->with('success', 'Foto berhasil dihapus dari portofolio Anda.');
    }

    // ==========================================
    // MENAMPILKAN HALAMAN EDIT
    // ==========================================
    public function edit($id)
    {
        $photo = Photo::findOrFail($id);

        // Keamanan: Pastikan hanya pemilik foto yang bisa mengedit
        if ($photo->user_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak! Anda bukan pemilik karya ini.');
        }

        return view('photo.edit', compact('photo'));
    }

    // ==========================================
    // MEMPROSES PERUBAHAN DATA KE DATABASE
    // ==========================================
    public function update(Request $request, $id)
    {
        $photo = Photo::findOrFail($id);

        if ($photo->user_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        // Simpan perubahan ke database
        $photo->title = $request->title;
        $photo->category_id = $request->category_id;
        $photo->price = $request->price;
        $photo->description = $request->description;
        $photo->save();

        return redirect()->route('dashboard')->with('success', 'Karya berhasil diperbarui!');
    }
}