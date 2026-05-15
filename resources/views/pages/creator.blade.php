@extends('layouts.frontend')
@section('title', $creator->name . ' Profile - SendYourPhotos')

@php
    // Kita panggil lagi variabel warnanya agar bisa dipakai di dalam desain kartu profil
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
<main class="pt-32 pb-20">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-16">
        
        <!-- Background Card dengan Gradasi Halus & Shadow Elegan -->
        <div class="relative bg-gradient-to-br from-[{{ $light }}] via-white to-[{{ $primary }}]/10 border border-[{{ $borderLight }}] rounded-[3rem] p-10 flex flex-col md:flex-row items-start md:items-center gap-10 overflow-hidden shadow-2xl shadow-[{{ $primary }}]/10">
            
            <!-- Lingkaran Inisial Nama -->
            <div class="relative z-10 w-32 h-32 md:w-44 md:h-44 bg-[{{ $primary }}] text-white rounded-full flex items-center justify-center text-5xl md:text-7xl font-black border-8 border-white shadow-xl shrink-0">
                {{ substr($creator->name, 0, 1) }}
            </div>

            <div class="relative z-10 flex-1 w-full text-center md:text-left">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-3">
                    <div>
                        <span class="bg-[{{ $secondary }}] text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-[0.2em] mb-3 inline-block shadow-sm">Official Contributor</span>
                        <h1 class="text-4xl md:text-5xl font-extrabold text-[{{ $secondary }}]">{{ $creator->name }}</h1>
                    </div>
                </div>
                
                <p class="text-gray-500 font-semibold text-sm mb-4">Bergabung sejak {{ $creator->created_at->format('M Y') }}</p>

                <!-- FITUR BIODATA KREATOR -->
                <div class="mt-4 mb-6 p-5 bg-white/60 backdrop-blur-sm rounded-2xl border border-white shadow-sm max-w-2xl text-left">
                    <h3 class="text-xs font-bold text-[{{ $primary }}] uppercase tracking-widest mb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Tentang Kreator
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed font-medium">
                        {{ $creator->bio ?? 'Seorang fotografer dan kreator digital yang berdedikasi tinggi terhadap seni visual. Menangkap setiap momen berharga dengan detail dan estetika memukau untuk menghasilkan karya-karya fotografi premium kelas dunia.' }}
                    </p>
                </div>
                
                <!-- KARTU STATISTIK PREMIUM -->
                <div class="flex flex-wrap justify-center md:justify-start gap-4">
                    <div class="bg-white px-6 py-4 rounded-2xl border border-[{{ $borderLight }}] shadow-sm shadow-[{{ $primary }}]/5 flex flex-col items-center md:items-start min-w-[140px]">
                        <p class="text-3xl font-black text-[{{ $primary }}]">{{ $creator->photos_count ?? (isset($photos) ? $photos->count() : 0) }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Total Photos</p>
                    </div>
                    <div class="bg-white px-6 py-4 rounded-2xl border border-[{{ $borderLight }}] shadow-sm shadow-[{{ $primary }}]/5 flex flex-col items-center md:items-start min-w-[140px]">
                        <p class="text-3xl font-black text-[{{ $primary }}]">Standard</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">License Type</p>
                    </div>
                </div>
            </div>

            <!-- Logo Daun Raksasa (Watermark) -->
            <div class="absolute -right-10 -bottom-10 opacity-10 text-[{{ $primary }}] transform rotate-12 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-64 h-64 md:w-96 md:h-96">
                    <path d="M12.963 2.286a.75.75 0 00-1.071-.136 9.742 9.742 0 00-3.539 6.177A7.547 7.547 0 016.648 6.61a.75.75 0 00-1.152.082A9 9 0 1015.68 4.534a7.46 7.46 0 01-2.717-2.248z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- PORTFOLIO KREATOR -->
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <h2 class="text-2xl font-black text-[{{ $secondary }}] mb-10 flex items-center gap-3">
            Portfolio Showcase
            <div class="flex-1 h-px bg-[{{ $borderLight }}]"></div>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($photos as $photo)
                <!-- ANIMASI LIFT & GLOW PADA KARTU -->
                <a href="{{ route('photo.show', $photo->id) }}" class="group block transform transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:shadow-[{{ $primary }}]/20 bg-white rounded-[2rem] overflow-hidden border border-[{{ $borderLight }}]">
                    <div class="aspect-[4/5] overflow-hidden bg-[{{ $light }}] relative">
                        <img src="{{ asset('storage/' . $photo->file_path) }}" alt="{{ $photo->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-[{{ $secondary }}]/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="p-6 relative bg-white z-10">
                        <h3 class="font-bold text-[{{ $secondary }}] text-lg mb-2 truncate group-hover:text-[{{ $primary }}] transition-colors">{{ $photo->title }}</h3>
                        <p class="text-sm font-black text-[{{ $primary }}]">Rp {{ number_format($photo->price, 0, ',', '.') }}</p>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="w-20 h-20 bg-[{{ $light }}] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[{{ $primary }}]/50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <p class="text-[{{ $primary }}] font-bold text-lg">Kreator ini belum mengunggah karya.</p>
                </div>
            @endforelse
        </div>
    </div>
</main>
@endsection