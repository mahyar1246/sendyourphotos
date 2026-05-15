@extends('layouts.frontend')
@section('title', $photo->title . ' - SendYourPhotos')

@php
    // Variabel warna sudah dilengkapi dengan $light dan $borderLight
    $currentTheme = session('user_theme', 'autumn');
    if ($currentTheme == 'forest') {
        $bg = '#E8F3E8'; $primary = '#2D5A27'; $secondary = '#1B3022';
        $accent = '#82A766'; $hover = '#1F401B'; $light = '#F0FDF4'; $borderLight = '#DCFCE7';
    } elseif ($currentTheme == 'ocean') {
        $bg = '#E0F2F7'; $primary = '#076678'; $secondary = '#002B36';
        $accent = '#268BD2'; $hover = '#044e5c'; $light = '#ECFEFF'; $borderLight = '#CFFAFE';
    } else {
        $bg = '#F4ECE6'; $primary = '#C84B31'; $secondary = '#3E2723';
        $accent = '#E7993A'; $hover = '#A63C25'; $light = '#FFF7ED'; $borderLight = '#FFEDD5';
    }
@endphp

@section('content')
<!-- Tombol Back (Opsional, karena di navbar frontend sudah ada 'Explore Gallery') -->
<div class="max-w-7xl mx-auto px-6 lg:px-8 pt-28">
    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-[{{ $primary }}] transition-colors font-bold text-sm bg-white/60 hover:bg-white backdrop-blur-sm px-4 py-2 rounded-full shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Back to Gallery
    </a>
</div>

<div class="pt-6 pb-24 max-w-7xl mx-auto px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row gap-12 items-start">
        
        <!-- SISI KIRI: DISPLAY FOTO -->
        <div class="w-full lg:w-2/3">
            <div class="relative flex items-center justify-center w-full min-h-[70vh] bg-[{{ $accent }}]/10 backdrop-blur-sm rounded-[2.5rem] p-6 sm:p-12 shadow-inner border border-[{{ $accent }}]/20 overflow-hidden group">
                
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-3/4 h-3/4 bg-white/60 blur-[100px] rounded-full z-0 pointer-events-none"></div>

                <!-- KOTAK GAMBAR (FITUR ANTI-MALING) -->
                <div class="relative z-10 bg-white p-3 sm:p-5 rounded-2xl shadow-xl shadow-[{{ $secondary }}]/10 border border-white transition-all duration-700 ease-out hover:scale-[1.02] hover:shadow-[{{ $secondary }}]/20">
                    <img src="{{ asset('storage/' . $photo->file_path) }}" 
                         alt="{{ $photo->title }}" 
                         class="w-full h-auto max-h-[75vh] object-contain rounded-lg select-none pointer-events-none"
                         oncontextmenu="return false;" 
                         draggable="false">
                    <!-- Lapisan transparan pelindung klik kanan -->
                    <div class="absolute inset-0 z-20" oncontextmenu="return false;"></div>
                </div>
                
                <!-- Ornamen Titik-titik -->
                <div class="absolute top-8 left-8 w-2 h-2 rounded-full bg-[{{ $accent }}]/50 shadow-sm"></div>
                <div class="absolute top-8 right-8 w-2 h-2 rounded-full bg-[{{ $accent }}]/50 shadow-sm"></div>
                <div class="absolute bottom-8 left-8 w-2 h-2 rounded-full bg-[{{ $accent }}]/50 shadow-sm"></div>
                <div class="absolute bottom-8 right-8 w-2 h-2 rounded-full bg-[{{ $accent }}]/50 shadow-sm"></div>
            </div>
        </div>

        <!-- SISI KANAN: DETAIL & CHECKOUT -->
        <div class="w-full lg:w-1/3 sticky top-32 space-y-8">
            
            <div>
                <span class="bg-white/60 backdrop-blur-sm text-[{{ $primary }}] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-4 inline-block border border-[{{ $borderLight }}]">
                    Featured Shot
                </span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-[{{ $secondary }}] leading-tight mb-4 tracking-tight">{{ $photo->title }}</h1>
                <p class="text-gray-600 text-lg leading-relaxed font-medium">{{ $photo->description }}</p>
            </div>

            <!-- LINK MENUJU PROFIL KREATOR -->
            <a href="{{ route('creator.profile', $photo->user_id) }}" class="flex items-center gap-4 py-6 border-y border-[{{ $borderLight }}] group hover:bg-white/50 rounded-xl transition-all p-2 -ml-2">
                <div class="w-14 h-14 bg-[{{ $secondary }}] text-white rounded-full flex items-center justify-center text-xl font-bold shadow-md uppercase group-hover:scale-105 transition-transform">
                    {{ substr($photo->user->name ?? 'U', 0, 1) }}
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-0.5">Creator</p>
                    <p class="text-lg font-black text-gray-900 group-hover:text-[{{ $primary }}] transition-colors">{{ $photo->user->name ?? 'Unknown Creator' }}</p>
                </div>
            </a>

            <!-- KOTAK HARGA -->
            <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-[{{ $primary }}]/10 border border-[{{ $borderLight }}]">
                <div class="mb-6">
                    <p class="text-sm text-gray-500 font-bold mb-1 uppercase tracking-widest">Standard License</p>
                    <p class="text-5xl font-extrabold text-[{{ $secondary }}] tracking-tight">
                        Rp {{ number_format($photo->price, 0, ',', '.') }}
                    </p>
                </div>

                <a href="{{ route('checkout', $photo->id) }}" class="w-full bg-[{{ $primary }}] text-white font-black text-lg px-8 py-4 rounded-xl hover:bg-[{{ $hover }}] transition-all active:scale-[0.98] shadow-xl shadow-[{{ $primary }}]/30 flex items-center justify-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    Purchase License
                </a>

                <ul class="mt-6 space-y-3 text-sm text-gray-600 font-medium">
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[{{ $primary }}]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        High-Resolution without Watermark
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[{{ $primary }}]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Commercial & Personal Use
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection