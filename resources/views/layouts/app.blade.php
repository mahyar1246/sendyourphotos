@php
    $currentTheme = session('user_theme', 'autumn');
    
    // Logika Tema Warna & Gambar Latar Belakang (Hero Image)
    if ($currentTheme == 'forest') {
        $bg = '#E8F3E8'; $primary = '#2D5A27'; $secondary = '#1B3022';
        $accent = '#82A766'; $hover = '#1F401B'; $light = '#F0FDF4'; $borderLight = '#DCFCE7';
        // Gambar Hutan
        $heroImage = 'https://images.unsplash.com/photo-1448375240586-882707db888b?q=80&w=1600&auto=format&fit=crop';
    } elseif ($currentTheme == 'ocean') {
        $bg = '#E0F2F7'; $primary = '#076678'; $secondary = '#002B36';
        $accent = '#268BD2'; $hover = '#044e5c'; $light = '#ECFEFF'; $borderLight = '#CFFAFE';
        // Gambar Laut
        $heroImage = 'https://images.unsplash.com/photo-1505118380757-91f5f5632de0?q=80&w=1600&auto=format&fit=crop';
    } else { // Autumn (Default)
        $bg = '#F4ECE6'; $primary = '#C84B31'; $secondary = '#3E2723';
        $accent = '#E7993A'; $hover = '#A63C25'; $light = '#FFF7ED'; $borderLight = '#FFEDD5';
        // Gambar Musim Gugur (Autumn)
        $heroImage = 'https://images.unsplash.com/photo-1507371341162-763b5e419408?q=80&w=1600&auto=format&fit=crop';
    }
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SendYourPhotos')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: {{ $bg }}; 
            transition: background-color 0.5s ease;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #d6d3d1; border-radius: 20px; }
        
        /* Modif SweetAlert */
        .swal2-popup.compact-alert {
            width: 22em !important;
            padding: 1.5em !important;
            border-radius: 1.5rem !important;
        }
        .swal2-title.compact-title { font-size: 1.25rem !important; }
        .swal2-html-container.compact-text { font-size: 0.875rem !important; margin-top: 0.5em !important;}
        .swal2-icon.compact-icon { transform: scale(0.7) !important; margin: 0 auto 0.5em auto !important;}
    </style>
</head>
<body class="p-0 md:p-6 h-screen w-screen overflow-hidden flex justify-center items-center">

    <div class="w-full max-w-[1400px] h-full md:h-[90vh] bg-white md:rounded-[2rem] shadow-2xl overflow-hidden flex flex-col relative md:border-[8px] md:border-[{{ $secondary }}]">
        
        <header class="px-4 md:px-8 py-4 md:py-5 flex justify-between items-center border-b border-gray-100 z-20 bg-white shadow-sm">
            <div class="flex items-center gap-2 md:gap-3">
                <div class="w-8 h-8 bg-[{{ $primary }}] rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md shadow-[{{ $primary }}]/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span class="font-bold text-gray-800 text-base md:text-lg tracking-tight hidden sm:block">SendYourPhotos</span>
                <span class="ml-1 md:ml-2 px-2 py-0.5 bg-[{{ $light }}] text-[10px] font-bold text-[{{ $primary }}] rounded-md uppercase border border-[{{ $borderLight }}]">
                    {{ $user->role == 'contributor' ? 'DISTRIBUTOR' : 'BUYER' }}
                </span>
            </div>

            <div class="flex items-center gap-3 md:gap-4">
                <a href="{{ route('home') }}" class="hidden sm:block text-sm font-semibold text-gray-500 hover:text-[{{ $primary }}] transition-colors">Back to Gallery</a>
                <span class="text-xs md:text-sm font-medium text-gray-600 sm:px-3 sm:border-l border-gray-200">
                    Hi, <span class="font-bold text-gray-900">{{ explode(' ', $user->name)[0] }}</span>
                </span>
                
                <form id="logout-form-global" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                
                <button type="button" onclick="confirmLogoutGlobal()" class="p-2 hover:bg-red-50 rounded-full text-red-500 transition-colors" title="Logout">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>

            </div>
        </header>

        <div class="flex flex-col md:flex-row flex-1 overflow-hidden bg-[{{ $light }}]/40 relative">
            
            <nav class="w-full md:w-20 h-16 md:h-auto shrink-0 bg-white border-t md:border-t-0 md:border-r border-gray-100 flex flex-row md:flex-col items-center justify-around md:justify-start gap-4 md:gap-6 md:py-6 z-20 order-last md:order-first pb-safe">
                
                <a href="{{ route('dashboard') }}" title="Dashboard" class="w-10 h-10 md:w-12 md:h-12 {{ request()->routeIs('dashboard') ? 'bg-['.$secondary.'] text-white shadow-lg' : 'hover:bg-['.$light.'] text-gray-400 hover:text-['.$primary.']' }} rounded-xl flex items-center justify-center transition-all active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                </a>
                
                <a href="{{ route('home') }}" title="Back to Gallery" class="w-10 h-10 md:w-12 md:h-12 {{ request()->routeIs('home') ? 'bg-['.$secondary.'] text-white shadow-lg' : 'hover:bg-['.$light.'] text-gray-400 hover:text-['.$primary.']' }} rounded-xl flex items-center justify-center transition-all active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                </a>
                
                @if($user->role == 'contributor')
                <a href="{{ route('earnings.index') }}" title="Earnings & Sales" class="w-10 h-10 md:w-12 md:h-12 {{ request()->routeIs('earnings.*') ? 'bg-['.$secondary.'] text-white shadow-lg' : 'hover:bg-['.$light.'] text-gray-400 hover:text-['.$primary.']' }} rounded-xl flex items-center justify-center transition-all active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </a>
                @endif
                
            </nav>

            <div class="flex flex-col md:flex-row flex-1 overflow-y-auto md:overflow-hidden w-full relative custom-scrollbar">
                 @yield('content')
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Fungsi  Logout 
        function confirmLogoutGlobal() {
            Swal.fire({
                title: 'Ingin Keluar?',
                text: "Sesi Anda akan diakhiri.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444', // Merah Tailwind agar pas dengan icon
                cancelButtonColor: '#F3F4F6', // Abu-abu
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: '<span style="color: #4B5563">Batal</span>',
                reverseButtons: true,
                customClass: {
                    popup: 'compact-alert shadow-2xl border-none', 
                    title: 'compact-title font-bold text-gray-800',
                    htmlContainer: 'compact-text text-gray-500',
                    icon: 'compact-icon',
                    confirmButton: 'rounded-xl font-bold px-4 py-2 text-sm transition-transform active:scale-95',
                    cancelButton: 'rounded-xl font-bold px-4 py-2 text-sm transition-transform active:scale-95'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form-global').submit();
                }
            });
        }

        // Script untuk Toast (Notifikasi Berhasil/Gagal)
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                customClass: { popup: 'rounded-2xl shadow-xl border border-gray-100 z-[9999]' }
            });

            @if(session('success'))
                Toast.fire({ icon: 'success', title: 'Berhasil!', text: "{!! addslashes(session('success')) !!}" });
            @endif

            @if(session('error') || $errors->any())
                Toast.fire({ icon: 'error', title: 'Oops...', text: "{!! addslashes(session('error') ?? $errors->first()) !!}" });
            @endif
        });
    </script>
</body>
</html>