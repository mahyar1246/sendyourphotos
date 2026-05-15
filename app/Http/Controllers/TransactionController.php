<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Transaction;

class TransactionController extends Controller
{
    // Menampilkan halaman ringkasan pesanan (Checkout)
    public function checkout($id)
    {
        // Cari foto berdasarkan ID
        $photo = Photo::findOrFail($id);
        
        // Tampilkan halaman checkout dan bawa data fotonya
        // SUDAH DIUPDATE: Mengarah ke folder 'transaction'
        return view('dashboard.checkout', compact('photo'));
    }

    // Memproses data pembayaran
    public function process(Request $request, $id)
    {
        $photo = Photo::findOrFail($id);

        // 1. Catat transaksi ke dalam database
        Transaction::create([
            'user_id' => auth()->id(), // ID pembeli yang sedang login
            'photo_id' => $photo->id,  // ID foto yang dibeli
            'amount' => $photo->price, // Harga foto
            'payment_status' => 'success', // Kita anggap langsung lunas untuk simulasi ini
        ]);

        // 2. Lempar pembeli ke halaman Dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil! Anda sekarang memiliki lisensi foto ini.');
    }
}