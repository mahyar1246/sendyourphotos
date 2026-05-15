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
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'SendYourPhotos - Premium Photography Gallery')</title>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: {{ $bg }};
            transition: background-color 0.5s ease;
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="antialiased text-gray-900 bg-[{{ $bg }}]">

    <!--  WRAPPER  -->
    <div class="w-full max-w-[100vw] overflow-x-hidden relative flex flex-col min-h-screen">

        <!-- NAVBAR GLOBAL -->
        <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100/50 shadow-sm transition-all top-0">
            <div class="w-full max-w-7xl mx-auto px-4 lg:px-8">
                <div class="flex justify-between items-center h-20 w-full">
                    
                    <!-- LOGO -->
                    <a href="{{ route('home') }}" class="flex items-center gap-2 md:gap-3 cursor-pointer group shrink-0">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-[{{ $primary }}] rounded-xl flex items-center justify-center text-white shadow-lg shrink-0 group-hover:-rotate-12 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 md:w-6 md:h-6">
                                <path d="M12.963 2.286a.75.75 0 00-1.071-.136 9.742 9.742 0 00-3.539 6.177A7.547 7.547 0 016.648 6.61a.75.75 0 00-1.152.082A9 9 0 1015.68 4.534a7.46 7.46 0 01-2.717-2.248z" />
                            </svg>
                        </div>
                        <span class="font-bold text-[{{ $secondary }}] text-lg md:text-xl tracking-tight">SendYourPhotos</span>
                    </a>

                    <!-- MENU LAPTOP -->
                    <div class="hidden md:flex items-center gap-6 shrink-0">
                        <a href="{{ route('home') }}#main-gallery" class="text-sm font-bold text-gray-500 hover:text-[{{ $primary }}]">Explore</a>
                        <button onclick="document.getElementById('license-modal').classList.remove('hidden')" class="text-sm font-bold text-gray-500">License</button>
                        
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-[{{ $primary }}] py-4">Theme</button>
                            <div class="absolute hidden group-hover:block top-[80%] right-0 pt-2 w-44 z-50">
                                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                                    <a href="{{ route('set.theme', 'autumn') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-orange-50"><span class="w-3 h-3 rounded-full bg-[#C84B31]"></span><span class="text-sm font-bold text-gray-700">Autumn</span></a>
                                    <a href="{{ route('set.theme', 'forest') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-green-50"><span class="w-3 h-3 rounded-full bg-[#2D5A27]"></span><span class="text-sm font-bold text-gray-700">Forest</span></a>
                                    <a href="{{ route('set.theme', 'ocean') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-cyan-50"><span class="w-3 h-3 rounded-full bg-[#076678]"></span><span class="text-sm font-bold text-gray-700">Ocean</span></a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="w-px h-6 bg-gray-200"></div>

                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-[{{ $secondary }}] hover:text-[{{ $primary }}]">My Dashboard</a>
                            <a href="{{ route('creator.profile', Auth::user()->id) }}" title="My Profile" class="shrink-0 w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-[{{ $primary }}] font-bold border-2 border-[{{ $primary }}]/20 shadow-sm hover:scale-110 transition-all text-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-bold text-[{{ $secondary }}] hover:text-[{{ $primary }}]">Sign In</a>
                            <a href="{{ route('register') }}" class="shrink-0 bg-[{{ $secondary }}] text-white text-sm font-bold px-6 py-2.5 rounded-full hover:bg-[{{ $primary }}] shadow-lg transition-all active:scale-95">Join Free</a>
                        @endauth
                    </div>

                    <!-- TOMBOL HAMBURGER HP -->
                    <div class="md:hidden flex items-center shrink-0">
                        <button id="mobile-menu-btn" class="p-2 text-gray-600 hover:text-[{{ $primary }}] focus:outline-none transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- MENU DROPDOWN HP -->
            <div id="mobile-menu" class="hidden md:hidden absolute w-full bg-white border-b border-gray-100 shadow-xl top-20 left-0 max-h-[80vh] overflow-y-auto z-50">
                <div class="px-4 py-6 flex flex-col gap-3">
                    <a href="{{ route('home') }}#main-gallery" class="px-4 py-3 bg-gray-50 rounded-xl text-base font-bold text-gray-700 hover:text-[{{ $primary }}]">Explore Gallery</a>
                    <button onclick="document.getElementById('license-modal').classList.remove('hidden'); document.getElementById('mobile-menu').classList.add('hidden');" class="text-left px-4 py-3 bg-gray-50 rounded-xl text-base font-bold text-gray-700 hover:text-[{{ $primary }}]">License Info</button>

                    <div class="px-4 py-3 bg-gray-50 rounded-xl mt-2">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Choose Theme</p>
                        <div class="grid grid-cols-3 gap-3">
                            <a href="{{ route('set.theme', 'autumn') }}" class="flex justify-center py-2 bg-white rounded-lg shadow-sm border border-gray-100"><span class="w-4 h-4 rounded-full bg-[#C84B31]"></span></a>
                            <a href="{{ route('set.theme', 'forest') }}" class="flex justify-center py-2 bg-white rounded-lg shadow-sm border border-gray-100"><span class="w-4 h-4 rounded-full bg-[#2D5A27]"></span></a>
                            <a href="{{ route('set.theme', 'ocean') }}" class="flex justify-center py-2 bg-white rounded-lg shadow-sm border border-gray-100"><span class="w-4 h-4 rounded-full bg-[#076678]"></span></a>
                        </div>
                    </div>

                    <div class="w-full h-px bg-gray-200 my-2"></div>

                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-3 bg-[{{ $light }}] rounded-xl text-base font-bold text-[{{ $primary }}]">My Dashboard</a>
                        <a href="{{ route('creator.profile', Auth::user()->id) }}" class="px-4 py-3 bg-gray-50 rounded-xl text-base font-bold text-gray-700">My Profile</a>
                        <form action="{{ route('logout') }}" method="POST" class="mt-2 w-full">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 bg-red-50 rounded-xl text-base font-bold text-red-600 hover:bg-red-100">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-3 bg-gray-50 rounded-xl text-base font-bold text-gray-700 text-center border border-gray-200">Sign In</a>
                        <a href="{{ route('register') }}" class="px-4 py-3 bg-[{{ $secondary }}] rounded-xl text-base font-bold text-white text-center shadow-lg">Join Free</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- KONTEN HALAMAN (HOME) -->
        <main class="flex-1 w-full pt-20 overflow-hidden">
            @yield('content')
        </main>

        <!-- MODAL LICENSE -->
        <div id="license-modal" class="fixed inset-0 z-[60] hidden flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="document.getElementById('license-modal').classList.add('hidden')"></div>
            <div class="relative z-10 w-full max-w-lg bg-white rounded-[2rem] p-6 md:p-8 shadow-2xl border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl md:text-2xl font-black text-[{{ $secondary }}]">Standard Licensing</h3>
                    <button onclick="document.getElementById('license-modal').classList.add('hidden')" class="text-gray-400 hover:text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <div class="space-y-4 text-gray-600 text-sm md:text-base leading-relaxed">
                    <p>Setiap foto yang Anda beli di <strong>SendYourPhotos</strong> disertai dengan Lisensi Standar yang mencakup penggunaan komersial, modifikasi, dan file High-Res.</p>
                </div>
                <button onclick="document.getElementById('license-modal').classList.add('hidden')" class="mt-6 w-full bg-[{{ $primary }}] text-white font-bold py-3.5 rounded-xl hover:opacity-90 transition-all active:scale-[0.98]">Saya Mengerti</button>
            </div>
        </div>

       

    </div> <!--  END WRAPPER -->

    <!-- SCRIPT WAJIB -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true, offset: 100 });
        
        // Script Hamburger Menu
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 4000 });
            @if(session('success')) Toast.fire({ icon: 'success', title: 'Berhasil!', text: "{!! addslashes(session('success')) !!}" }); @endif
            @if(session('error') || $errors->any()) Toast.fire({ icon: 'error', title: 'Oops...', text: "{!! addslashes(session('error') ?? $errors->first()) !!}" }); @endif
        });
    </script>
    @stack('scripts')
</body>
</html>