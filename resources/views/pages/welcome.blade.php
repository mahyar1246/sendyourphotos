@extends('layouts.frontend')
@section('title', 'SendYourPhotos - Premium Photography Gallery')

@php
    $currentTheme = session('user_theme', 'autumn');
    if ($currentTheme == 'forest') {
        $bg = '#E8F3E8'; $primary = '#2D5A27'; $secondary = '#1B3022';
        $accent = '#82A766'; $hover = '#1F401B'; $light = '#F0FDF4'; $borderLight = '#DCFCE7';
        // Gambar Hutan yang lebih rimbun dan hijau dalam
        $heroImage = 'https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?q=80&w=1600&auto=format&fit=crop';
    } elseif ($currentTheme == 'ocean') {
        $bg = '#E0F2F7'; $primary = '#076678'; $secondary = '#002B36';
        $accent = '#268BD2'; $hover = '#044e5c'; $light = '#ECFEFF'; $borderLight = '#CFFAFE';
        $heroImage = 'https://images.unsplash.com/photo-1505118380757-91f5f5632de0?q=80&w=1600&auto=format&fit=crop';
    } else {
        $bg = '#F4ECE6'; $primary = '#C84B31'; $secondary = '#3E2723';
        $heroImage = 'https://images.unsplash.com/photo-1507371341162-763b5e419408?q=80&w=1600&auto=format&fit=crop';
    }
    

    // Variabel Class Tailwind untuk Tombol Kategori (REFACTORING)
    $btnBase = "px-6 py-2.5 rounded-xl text-sm font-bold border transition-all whitespace-nowrap";
    $btnActive = "bg-[".$primary."] text-white border-transparent";
    $btnInactive = "bg-white text-gray-600 hover:text-[".$primary."] border-gray-200";
@endphp

@section('content')
    <div class="relative h-screen flex items-center justify-center bg-fixed bg-center bg-cover transition-all duration-700" style="background-image: url('{{ $heroImage }}');">
        <div class="absolute inset-0 bg-black/50 bg-gradient-to-t from-[{{ $bg }}] via-transparent to-transparent"></div>
        
        <div class="relative z-10 text-center px-6 mt-16" data-aos="zoom-in" data-aos-duration="1000">
            <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight text-white mb-6 leading-tight drop-shadow-lg">
                Discover & Collect <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-gray-300 to-[{{ $primary }}]">
                    Breathtaking Visuals.
                </span>
            </h1>
            <p class="text-lg lg:text-xl text-gray-100 max-w-2xl mx-auto font-medium mb-10 drop-shadow-md">
                Explore premium, high-resolution photos from top creators around the world. Buy with confidence, create with passion.
            </p>
            
            <form action="{{ route('home') }}" method="GET" class="max-w-2xl mx-auto bg-white/20 backdrop-blur-md p-2 rounded-full shadow-2xl border border-white/30 flex items-center" data-aos="fade-up" data-aos-delay="300">
                <div class="pl-4 pr-2 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search for aesthetics, cityscapes..." class="w-full py-3 px-2 bg-transparent outline-none text-white placeholder-gray-200 font-medium focus:ring-0 border-none">
                <button type="submit" class="bg-[{{ $primary }}] text-white px-8 py-3 rounded-full font-bold hover:bg-[{{ $secondary }}] transition-colors shadow-lg active:scale-95">Search</button>
            </form>
        </div>
    </div>

    <div id="main-gallery" class="max-w-7xl mx-auto px-6 lg:px-8 pb-24 mt-12 scroll-mt-24">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div data-aos="fade-right">
                <h2 class="text-3xl font-extrabold text-[{{ $secondary }}] tracking-tight">
                    {{ request('search') ? 'Search Results for "' . request('search') . '"' : 'Curated Collections' }}
                </h2>
                <p class="text-gray-500 mt-2 font-medium">Explore the best photography from our global community.</p>
            </div>
            
            <div class="flex gap-3 overflow-x-auto no-scrollbar py-2" data-aos="fade-left" data-aos-delay="100">
                <a href="{{ route('home') }}" class="{{ $btnBase }} {{ !request('category') ? $btnActive : $btnInactive }}">All Works</a>
                <a href="{{ route('home', ['category' => 1]) }}" class="{{ $btnBase }} {{ request('category') == 1 ? $btnActive : $btnInactive }}">Nature</a>
                <a href="{{ route('home', ['category' => 2]) }}" class="{{ $btnBase }} {{ request('category') == 2 ? $btnActive : $btnInactive }}">Architecture</a>
                <a href="{{ route('home', ['category' => 3]) }}" class="{{ $btnBase }} {{ request('category') == 3 ? $btnActive : $btnInactive }}">Street</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($photos as $photo)
                <div class="group" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                    <div class="relative bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100">
                        <a href="{{ route('photo.show', $photo->id) }}">
                            <div class="aspect-[4/5] overflow-hidden bg-gray-50 relative">
                            <img src="{{ asset('storage/' . $photo->file_path) }}" alt="{{ $photo->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-[{{ $secondary }}]/90 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        </a>
                        <div class="p-6 bg-white">
                            <a href="{{ route('photo.show', $photo->id) }}">
                                <h3 class="font-bold text-[{{ $secondary }}] text-lg mb-4 truncate group-hover:text-[{{ $primary }}] transition-colors">{{ $photo->title }}</h3>
                            </a>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-gray-50 flex items-center justify-center text-[10px] font-bold text-[{{ $primary }}] border border-gray-100 uppercase">
                                        {{ substr($photo->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <a href="{{ route('creator.profile', $photo->user_id) }}" class="text-xs font-bold text-gray-600 hover:text-[{{ $primary }}] transition-colors truncate max-w-[80px]">
                                        {{ $photo->user->name ?? 'Creator' }}
                                    </a>
                                </div>
                                <span class="text-sm font-black text-[{{ $primary }}]">
                                    Rp {{ number_format($photo->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center" data-aos="fade-in">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <p class="text-gray-400 font-bold text-lg">Maaf, tidak ada foto yang ditemukan untuk pencarian ini.</p>
                    <a href="{{ route('home') }}" class="mt-4 inline-block text-[{{ $primary }}] font-bold hover:underline">← Kembali ke Semua Karya</a>
                </div>
            @endforelse
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-24" data-aos="zoom-in-up" data-aos-offset="150">
        <div class="bg-[{{ $secondary }}] rounded-[3rem] p-12 lg:p-20 relative overflow-hidden text-center lg:text-left flex flex-col lg:flex-row items-center justify-between gap-10 shadow-2xl">
            <div class="relative z-10 max-w-xl">
                <h2 class="text-4xl lg:text-5xl font-extrabold text-white leading-tight">Ready to sell your masterpieces?</h2>
                <p class="mt-4 text-white/70 text-lg font-medium">Join thousands of professional photographers and start earning from your passion today.</p>
            </div>
            <div class="relative z-10 flex flex-col sm:flex-row gap-4">
                
                @guest
                    <a href="{{ route('register') }}?as=contributor" class="bg-[{{ $primary }}] text-white px-10 py-5 rounded-2xl font-bold text-lg hover:bg-white hover:text-[{{ $primary }}] transition-all shadow-xl text-center">Become a Contributor</a>
                @endguest

                @auth
                    @if(auth()->user()->role === 'buyer')
                        <a href="{{ route('upgrade.terms') }}" class="bg-[{{ $primary }}] text-white px-10 py-5 rounded-2xl font-bold text-lg hover:bg-white hover:text-[{{ $primary }}] transition-all shadow-xl text-center">Become a Contributor</a>
                    @else
                        <a href="{{ route('upload') }}" class="bg-[{{ $primary }}] text-white px-10 py-5 rounded-2xl font-bold text-lg hover:bg-white hover:text-[{{ $primary }}] transition-all shadow-xl text-center">Upload Photo</a>
                    @endif
                @endauth
                
                <button class="bg-white/10 backdrop-blur-md text-white border border-white/20 px-10 py-5 rounded-2xl font-bold text-lg hover:bg-white/20 transition-all">Learn More</button>
            </div>
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-[{{ $primary }}]/40 rounded-full blur-[100px]"></div>
        </div>
    </div>
@endsection