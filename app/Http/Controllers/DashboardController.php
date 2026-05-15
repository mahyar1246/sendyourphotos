<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); 

        $myPhotos = Photo::where('user_id', $user->id)->latest()->get();
        $myPhotoIds = $myPhotos->pluck('id');

        $purchases = Transaction::where('user_id', $user->id)
                        ->where('payment_status', 'success')
                        ->with('photo') 
                        ->latest()
                        ->get();

        // 1. TOTAL SEMUA PENDAPATAN (Tidak akan pernah berkurang)
        $totalEarnings = Transaction::whereIn('photo_id', $myPhotoIds)
                        ->where('payment_status', 'success')
                        ->sum('amount');

        // 2. SALDO AKTIF (Total Pendapatan dikurangi Dana yang sudah ditarik)
        $withdrawnAmount = $user->withdrawn_amount ?? 0;
        $currentBalance = $totalEarnings - $withdrawnAmount;

        $recentSales = Transaction::whereIn('photo_id', $myPhotoIds)
                        ->where('payment_status', 'success')
                        ->with(['photo', 'user']) 
                        ->latest()
                        ->take(5)
                        ->get();

        return view('dashboard.dashboard', compact(
            'myPhotos', 
            'purchases', 
            'user', 
            'totalEarnings',      // Dikirim ke tampilan
            'currentBalance',     // Dikirim ke tampilan
            'recentSales'
        ));
    }

    public function upgradeToContributor()
    {
        $user = Auth::user();
        $user->role = 'contributor';
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Selamat! Akun Anda kini menjadi Distributor. Silakan mulai upload karya terbaik Anda.');
    }

    // ... (kode kurva pendapatan) ...

    public function earnings()
    {
        $user = Auth::user();
        
        if ($user->role !== 'contributor') {
            return redirect()->route('home');
        }

        $myPhotoIds = Photo::where('user_id', $user->id)->pluck('id');
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('D'); 

            $dailySum = Transaction::whereIn('photo_id', $myPhotoIds)
                            ->where('payment_status', 'success')
                            ->whereDate('created_at', $date->toDateString())
                            ->sum('amount');
            
            $data[] = $dailySum;
        }

        $chartData = [
            'labels' => $labels,
            'data' => $data,
            'total' => array_sum($data)
        ];

        return view('dashboard.earnings', compact('user', 'chartData')); 
    }


    // ==========================================
    // FUNGSI PENARIKAN DANA (LOGIKA PEMOTONGAN SALDO)
    // ==========================================
    public function withdraw(Request $request)
    {
        $user = Auth::user();

        // Hitung ulang saldo aktif saat ini
        $myPhotoIds = Photo::where('user_id', $user->id)->pluck('id');
        $totalEarnings = Transaction::whereIn('photo_id', $myPhotoIds)->where('payment_status', 'success')->sum('amount');
        
        $withdrawnAmount = $user->withdrawn_amount ?? 0;
        $currentBalance = $totalEarnings - $withdrawnAmount;

        // Cegah penarikan jika saldo kosong
        if ($currentBalance <= 0) {
            return back()->with('error', 'Gagal! Anda tidak memiliki saldo yang tersedia untuk ditarik.');
        }

        // Proses pemotongan saldo (Menambahkan jumlah uang yang ditarik ke database)
        $user->withdrawn_amount = $withdrawnAmount + $currentBalance;
        $user->save();

        return back()->with('success', 'Berhasil! Penarikan dana sebesar Rp ' . number_format($currentBalance, 0, ',', '.') . ' sedang diproses ke rekening Anda.');
    }

    public function downloadPhoto($id)
    {
        $hasPurchased = Transaction::where('user_id', auth()->id())
                            ->where('photo_id', $id)
                            ->where('payment_status', 'success')
                            ->first();

        if (!$hasPurchased && auth()->user()->role != 'contributor') {
            return back()->with('error', 'Akses ditolak! Anda harus membeli foto ini terlebih dahulu.');
        }

        $photo = Photo::findOrFail($id);
        $filePath = storage_path('app/public/' . $photo->file_path);

        return response()->download($filePath, 'Premium-' . $photo->title . '-SendYourPhotos.jpg');
    }

    // ==========================================
    // FUNGSI UPGRADE SYARAT & KETENTUAN (TERMS)
    // ==========================================
    
    // Menampilkan halaman syarat & ketentuan upgrade
    public function showUpgradeTerms()
    {
        // Pastikan hanya buyer yang bisa melihat halaman ini
        if (auth()->user()->role === 'contributor') {
            return redirect()->route('dashboard')->with('success', 'Anda sudah menjadi Contributor.');
        }

        // PERBAIKAN: Diarahkan ke folder dashboard sesuai lokasi file blade-mu
        return view('dashboard.upgrade-terms');
    }

    // Memproses persetujuan dan mengubah role
    public function processUpgrade(\Illuminate\Http\Request $request)
    { 
        $user = auth()->user();
        
        // Ubah role menjadi contributor
        $user->role = 'contributor';
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Selamat! Akun Anda telah di-upgrade. Anda sekarang bisa mulai menjual karya fotografi Anda.');
    }
}