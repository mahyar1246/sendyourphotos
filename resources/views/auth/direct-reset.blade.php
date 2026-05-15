@php
    $currentTheme = session('user_theme', 'autumn');
    if ($currentTheme == 'forest') {
        $primary = '#2D5A27'; $secondary = '#1B3022';
        $heroImage = 'https://images.unsplash.com/photo-1448375240586-882707db888b?q=80&w=1600&auto=format&fit=crop';
    } elseif ($currentTheme == 'ocean') {
        $primary = '#076678'; $secondary = '#002B36';
        $heroImage = 'https://images.unsplash.com/photo-1505118380757-91f5f5632de0?q=80&w=1600&auto=format&fit=crop';
    } else {
        $primary = '#C84B31'; $secondary = '#3E2723';
        $heroImage = 'https://images.unsplash.com/photo-1507371341162-763b5e419408?q=80&w=1600&auto=format&fit=crop';
    }
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Sandi Cepat - SendYourPhotos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative bg-cover bg-center" style="background-image: url('{{ $heroImage }}');">
    
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <div class="relative z-10 w-full max-w-md p-6 mt-10 mb-10">
        <div class="bg-white/95 backdrop-blur-xl rounded-[2rem] shadow-2xl overflow-hidden border border-white/50 p-8 md:p-10">
            
            <div class="mb-8 text-center">
                <div class="w-16 h-16 bg-[{{ $primary }}]/10 rounded-2xl mx-auto flex items-center justify-center text-[{{ $primary }}] mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Ganti Sandi</h1>
                <p class="text-sm text-gray-500 mt-2">Masukkan email terdaftar dan kata sandi baru Anda di bawah ini.</p>
            </div>

            <form action="{{ route('password.update.direct') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email Terdaftar</label>
                    <input type="email" name="email" required placeholder="Masukkan email akun" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[{{ $primary }}]/20 focus:border-[{{ $primary }}] transition-all">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[{{ $primary }}]/20 focus:border-[{{ $primary }}] transition-all">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password baru" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[{{ $primary }}]/20 focus:border-[{{ $primary }}] transition-all">
                </div>

                <button type="submit" class="w-full bg-[{{ $primary }}] text-white font-bold py-4 rounded-xl shadow-lg shadow-[{{ $primary }}]/30 hover:opacity-90 transition-all active:scale-95 mt-2">
                    Ubah Sandi Sekarang
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="{{ route('login') }}" class="text-sm font-bold text-gray-500 hover:text-[{{ $primary }}] transition-colors flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Batal dan kembali ke Login
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true, position: 'top-end', showConfirmButton: false, timer: 4000,
                customClass: { popup: 'rounded-2xl shadow-xl border border-gray-100' }
            });
            @if(session('success')) Toast.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}" }); @endif
            @if(session('error') || $errors->any()) Toast.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') ?? $errors->first() }}" }); @endif
        });
    </script>
</body>
</html>