@extends('layouts.app')
@section('title', 'Dashboard - SendYourPhotos')

@php
    $currentTheme = session('user_theme', 'autumn');
    
    if ($currentTheme == 'forest') {
        $bg = '#E8F3E8'; $primary = '#2D5A27'; $secondary = '#1B3022';
        $accent = '#82A766'; $hover = '#1F401B'; $light = '#F0FDF4'; $borderLight = '#DCFCE7';
        // Gambar Forest
        $heroImage = 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?q=80&w=1600&auto=format&fit=crop';
    } elseif ($currentTheme == 'ocean') {
        $bg = '#E0F2F7'; $primary = '#076678'; $secondary = '#002B36';
        $accent = '#268BD2'; $hover = '#044e5c'; $light = '#ECFEFF'; $borderLight = '#CFFAFE';
        // Gambar Ocean
        $heroImage = 'https://images.unsplash.com/photo-1505118380757-91f5f5632de0?q=80&w=1600&auto=format&fit=crop';
    } else {
        $bg = '#F4ECE6'; $primary = '#C84B31'; $secondary = '#3E2723';
        $accent = '#E7993A'; $hover = '#A63C25'; $light = '#FFF7ED'; $borderLight = '#FFEDD5';
        // Gambar Autumn (Jalanan musim gugur yang kamu mau)
        $heroImage = 'https://images.unsplash.com/photo-1507371341162-763b5e419408?q=80&w=1600&auto=format&fit=crop';
    }

    // Logika perhitungan data
    $totalSalesCount = 0;
    if(isset($myPhotos) && $user->role == 'contributor') {
        $totalSalesCount = \App\Models\Transaction::whereIn('photo_id', $myPhotos->pluck('id'))->where('payment_status', 'success')->count();
    }
    $totalSpent = 0;
    if(isset($purchases) && $user->role == 'buyer') {
        $totalSpent = $purchases->sum('amount');
    }
    $cardStyle = "bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-b-4 flex flex-col justify-between";
    $iconStyle = "h-5 w-5";
@endphp

@section('content')
<main class="flex-1 min-w-0 p-4 lg:p-8 overflow-y-auto relative custom-scrollbar transform-gpu will-change-scroll overscroll-contain">
    
    @if(session('success'))
    <div class="bg-[{{ $light }}] border-l-4 border-[{{ $primary }}] text-[{{ $secondary }}] p-4 mb-8 rounded-r-xl shadow-sm flex items-center justify-between" role="alert">
        <div>
            <p class="font-bold">Berhasil!</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[{{ $primary }}] opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
    </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Dashboard Overview</h2>
            <p class="text-gray-500 mt-1 text-sm md:text-base">Manage your collection and activities.</p>
        </div>
        @if($user->role == 'contributor') 
        <a href="{{ route('upload') }}" class="bg-[{{ $secondary }}] text-white px-6 py-3 rounded-xl font-semibold hover:opacity-90 transition-all flex items-center justify-center gap-2 shadow-lg w-full md:w-max active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
            Upload Photo
        </a>
        @endif
    </div>

    <div class="w-full h-[200px] md:h-[300px] rounded-[1.5rem] md:rounded-3xl mb-8 relative overflow-hidden group">
        <img src="{{ $heroImage }}" loading="lazy" alt="Featured Work" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
        <div class="absolute inset-0 bg-gradient-to-t from-[{{ $secondary }}]/90 to-transparent flex flex-col justify-end p-6 md:p-8 text-white">
            <span class="bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-[10px] md:text-xs font-semibold w-max mb-2">Featured Collection</span>
            <h3 class="text-xl md:text-2xl font-bold">Premium Aesthetic Series</h3>
        </div>
    </div>

    @if($user->role == 'contributor')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 md:gap-6 mb-12">
        <div class="lg:col-span-2 {{ $cardStyle }} border-b-[{{ $accent }}]">
            <div>
                <div class="flex items-center gap-3 text-gray-500 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconStyle }} text-[{{ $accent }}]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <span class="font-medium text-sm">Total Photos</span>
                </div>
                <h4 class="text-2xl md:text-3xl font-bold text-gray-900">{{ isset($myPhotos) ? $myPhotos->count() : 0 }}</h4>
                <p class="text-xs text-gray-400 mt-1">Uploaded to gallery</p>
            </div>
        </div>

        <div class="lg:col-span-2 {{ $cardStyle }} border-b-[{{ $primary }}]">
            <div>
                <div class="flex items-center gap-3 text-gray-500 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconStyle }} text-[{{ $primary }}]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    <span class="font-medium text-sm">Total Sales</span>
                </div>
                <h4 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $totalSalesCount }}</h4>
                <p class="text-xs text-gray-400 mt-1">Photos sold to buyers</p>
            </div>
        </div>

        <div class="lg:col-span-2 {{ $cardStyle }} border-b-[{{ $secondary }}]">
            <div>
                <div class="flex items-center gap-3 text-gray-500 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconStyle }} text-[{{ $secondary }}]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="font-medium text-sm">My Collection</span>
                </div>
                <h4 class="text-2xl md:text-3xl font-bold text-gray-900">{{ isset($purchases) ? $purchases->count() : 0 }}</h4>
                <p class="text-xs text-gray-400 mt-1">Photos in personal library</p>
            </div>
        </div>

        <div class="lg:col-start-2 lg:col-span-2 {{ $cardStyle }} border-b-[{{ $secondary }}]">
            <div>
                <div class="flex items-center gap-3 text-gray-500 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconStyle }} text-[{{ $secondary }}]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    <span class="font-medium text-sm">All-Time Earnings</span>
                </div>
                <h4 class="text-xl lg:text-3xl font-bold text-gray-900">Rp {{ isset($totalEarnings) ? number_format($totalEarnings, 0, ',', '.') : 0 }}</h4>
            </div>
        </div>

        <div class="lg:col-span-2 {{ $cardStyle }} border-b-[{{ $primary }}]">
            <div>
                <div class="flex items-center gap-3 text-gray-500 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconStyle }} text-[{{ $primary }}]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="font-medium text-sm">Available Balance</span>
                </div>
                <h4 class="text-xl lg:text-3xl font-bold text-gray-900">Rp {{ isset($currentBalance) ? number_format($currentBalance, 0, ',', '.') : 0 }}</h4>
            </div>
            @if(isset($currentBalance) && $currentBalance > 0)
            <form action="{{ route('withdraw') }}" method="POST" class="mt-4 border-t border-gray-100 pt-3">
                @csrf
                <button type="submit" onclick="return confirm('Tarik saldo?')" class="w-full bg-[{{ $primary }}] text-white text-xs font-bold py-2.5 rounded-xl hover:bg-[{{ $hover }}] transition-colors shadow-md active:scale-95">Withdraw Funds</button>
            </form>
            @else
            <div class="mt-4 border-t border-gray-100 pt-3">
                <button disabled class="w-full bg-gray-100 text-gray-400 text-xs font-bold py-2.5 rounded-xl cursor-not-allowed">Withdraw Funds</button>
            </div>
            @endif
        </div>
    </div>
    @else
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-12">
        <div class="{{ $cardStyle }} border-b-[{{ $accent }}]">
            <div>
                <div class="flex items-center gap-3 text-gray-500 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconStyle }} text-[{{ $accent }}]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    <span class="font-medium text-sm">Total Orders</span>
                </div>
                <h4 class="text-2xl md:text-3xl font-bold text-gray-900">{{ isset($purchases) ? $purchases->count() : 0 }}</h4>
            </div>
        </div>
        
        <div class="{{ $cardStyle }} border-b-[{{ $primary }}]">
            <div>
                <div class="flex items-center gap-3 text-gray-500 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconStyle }} text-[{{ $primary }}]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="font-medium text-sm">My Collection</span>
                </div>
                <h4 class="text-2xl md:text-3xl font-bold text-gray-900">{{ isset($purchases) ? $purchases->count() : 0 }}</h4>
            </div>
        </div>

        <div class="{{ $cardStyle }} border-b-[{{ $secondary }}]">
            <div>
                <div class="flex items-center gap-3 text-gray-500 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconStyle }} text-[{{ $secondary }}]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="font-medium text-sm">Total Investment</span>
                </div>
                <h4 class="text-xl md:text-3xl font-bold text-gray-900">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    @endif

    <div class="mb-14">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-[{{ $primary }}] tracking-tight flex items-center gap-2">
                    My Purchased Collection
                </h2>
                <p class="text-xs md:text-sm text-gray-500 mt-1">Download your high-resolution licensed photos here.</p>
            </div>
        </div>

        @if(isset($purchases) && $purchases->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                @foreach($purchases as $purchase)
                    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col group hover:shadow-xl transition-all duration-300">
                        <div class="aspect-[4/3] rounded-xl overflow-hidden bg-[{{ $light }}] mb-4 relative">
                            <img src="{{ asset('storage/' . $purchase->photo->file_path) }}" loading="lazy" alt="{{ $purchase->photo->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg text-xs font-bold text-[{{ $primary }}] shadow-sm">Licensed</div>
                        </div>
                        <h3 class="font-bold text-gray-900 text-base md:text-lg truncate">{{ $purchase->photo->title }}</h3>
                        <p class="text-xs text-gray-500 mb-4 mt-1">Creator: {{ $purchase->photo->user->name ?? 'Unknown' }}</p>
                        
                        <a href="{{ asset('storage/' . $purchase->photo->file_path) }}" download="{{ $purchase->photo->title }}-SendYourPhotos.jpg" class="mt-auto w-full bg-[{{ $primary }}] text-white font-bold text-xs md:text-sm py-2.5 rounded-xl hover:bg-[{{ $hover }}] transition-colors flex items-center justify-center gap-2 shadow-md shadow-[{{ $primary }}]/30 active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            Download
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="w-full bg-[{{ $light }}]/50 border border-dashed border-[{{ $borderLight }}] rounded-[1.5rem] p-6 md:p-8 flex flex-col items-center justify-center text-center">
                <p class="text-[{{ $secondary }}] text-xs md:text-sm font-medium">You haven't purchased any photos yet.</p>
            </div>
        @endif
    </div>

    @if($user->role == 'contributor')
    <div class="mt-12 border-t border-gray-100 pt-8">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 tracking-tight">Your Uploaded Portfolio</h2>
                <p class="text-xs md:text-sm text-gray-500 mt-1">Manage and view your uploaded masterpieces.</p>
            </div>
        </div>

        @if(isset($myPhotos) && $myPhotos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                @foreach($myPhotos as $photo)
                <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group cursor-pointer flex flex-col">
                    <div class="relative h-48 md:h-64 overflow-hidden bg-gray-100">
                        <img src="{{ asset('storage/' . $photo->file_path) }}" loading="lazy" alt="{{ $photo->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-lg font-bold text-gray-900 shadow-sm text-xs md:text-sm">
                            Rp {{ number_format($photo->price, 0, ',', '.') }}
                        </div>
                        <div class="absolute top-4 left-4 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity z-20 flex gap-2">
                            <a href="{{ route('photo.edit', $photo->id) }}" class="bg-white text-[{{ $primary }}] p-2 rounded-xl hover:bg-[{{ $light }}] transition-colors shadow-lg shadow-black/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                            </a>
                            <form action="{{ route('photo.delete', $photo->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-[{{ $primary }}] text-white p-2 rounded-xl hover:bg-[{{ $hover }}] transition-colors shadow-lg shadow-[{{ $primary }}]/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="p-4 md:p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-gray-800 text-base md:text-lg mb-1 truncate">{{ $photo->title }}</h3>
                            <p class="text-xs md:text-sm text-gray-500 line-clamp-2">{{ $photo->description }}</p>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between items-center">
                            <span class="text-[10px] md:text-xs font-medium px-2.5 py-1 bg-gray-100 text-gray-600 rounded-full">Uploaded</span>
                            <span class="text-[10px] md:text-xs text-gray-400 font-medium">{{ $photo->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="w-full bg-white border-2 border-dashed border-gray-200 rounded-[2rem] p-8 md:p-12 flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-[{{ $light }}] text-[{{ $primary }}] rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 md:h-10 md:w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2">No photos yet</h3>
                <p class="text-xs md:text-sm text-gray-500 max-w-sm mb-6">Your gallery is currently empty.</p>
                <a href="{{ route('upload') }}" class="bg-[{{ $primary }}] text-white px-6 py-3 rounded-full text-sm font-bold hover:bg-[{{ $hover }}] transition-colors shadow-lg shadow-[{{ $primary }}]/30 inline-block">Upload First Photo</a>
            </div>
        @endif
    </div>
    @endif
    
    <form id="logout-form-dashboard" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</main>

<aside class="w-full lg:w-80 shrink-0 p-4 lg:p-6 md:overflow-y-auto z-10 bg-white border-t lg:border-t-0 lg:border-l border-gray-100 custom-scrollbar">
    <div class="bg-[{{ $primary }}] text-white p-5 md:p-6 rounded-[1.5rem] mb-6 shadow-lg shadow-[{{ $primary }}]/40">
        <h3 class="font-bold text-base md:text-lg mb-4">Account Status</h3>
        <div class="space-y-4">
            <div class="flex gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center shrink-0">✓</div>
                <div>
                    <p class="text-xs md:text-sm font-semibold">Profile Active</p>
                    <p class="text-[10px] md:text-xs text-white/90 mt-1">Anda login sebagai <span class="font-bold underline">{{ $user->role == 'contributor' ? 'Distributor' : 'Buyer' }}</span>.</p>
                </div>
            </div>

            @if($user->role == 'buyer')
            <div class="mt-4 border-t border-[{{ $accent }}] pt-4">
                <a href="{{ route('upgrade.terms') }}" class="w-full bg-white text-[{{ $primary }}] text-[10px] md:text-[11px] font-black py-2.5 rounded-xl hover:bg-[{{ $light }}] transition-all uppercase tracking-wider shadow-sm flex justify-center items-center gap-2">
                    Mulai Jualan Foto 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>
            @endif

            @if($user->role == 'contributor')
            <div class="flex gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="text-xs md:text-sm font-semibold">Payment Setup</p>
                    <p class="text-[10px] md:text-xs text-white/90 mt-1">Link your bank account to receive payments.</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    @if($user->role == 'buyer')
    <div class="bg-white p-4 md:p-5 rounded-[1.5rem] border border-gray-100 shadow-sm mb-6 border-l-4 border-l-[{{ $primary }}]">
        <h3 class="font-bold text-gray-900 mb-2 text-sm md:text-base">Discover New Art</h3>
        <p class="text-[10px] md:text-xs text-gray-500 mb-4">Explore our latest premium collections from top creators around the world.</p>
        <a href="{{ route('home') }}" class="w-full bg-[{{ $light }}] text-[{{ $primary }}] text-[10px] md:text-xs font-bold py-3 rounded-xl hover:bg-gray-100 transition-all flex justify-center items-center gap-2">
            Explore Gallery
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
        </a>
    </div>

    <div class="glass-panel p-4 md:p-5 rounded-[1.5rem] bg-[{{ $light }}]/50 border border-[{{ $borderLight }}] mb-6">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-7 h-7 md:w-8 md:h-8 bg-[{{ $accent }}] rounded-lg flex items-center justify-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <h3 class="font-bold text-[{{ $secondary }}] text-xs md:text-sm">Buyer Protection</h3>
        </div>
        <p class="text-[10px] md:text-[11px] text-[{{ $secondary }}] leading-relaxed">
            Setiap foto yang Anda beli mendapatkan lisensi resmi. Simpan riwayat pesanan Anda untuk verifikasi lisensi di masa depan.
        </p>
    </div>
    @endif

    @if($user->role == 'contributor')
    <div class="glass-panel p-4 md:p-5 rounded-[1.5rem] bg-white border border-gray-100">
        <h3 class="font-bold text-gray-900 mb-1 text-sm md:text-base">Recent Sales</h3>
        <div class="space-y-4 mt-2">
            @forelse($recentSales as $sale)
                <div class="flex items-center gap-3 border-b border-gray-100 pb-3">
                    <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-[{{ $light }}] text-[{{ $primary }}] flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                    </div>
                    <div>
                        <p class="text-xs md:text-sm font-bold text-gray-800 line-clamp-1">{{ $sale->photo->title }}</p>
                        <p class="text-[10px] md:text-xs text-gray-500">Bought by <span class="font-semibold text-[{{ $primary }}]">{{ $sale->user->name }}</span></p>
                    </div>
                </div>
            @empty
                <p class="text-xs md:text-sm text-gray-600 font-medium text-center py-6">No sales yet</p>
            @endforelse
        </div>
    </div>
    @endif

    <div class="mt-auto pt-6 border-t border-gray-100">
        <button type="button" onclick="panggilAlertLogout()" class="w-full text-left px-4 py-3 bg-red-50 rounded-xl text-base font-bold text-red-600 hover:bg-red-100 transition-all flex items-center gap-3 active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Logout Account
        </button>
    </div>
</aside>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function panggilAlertLogout() {
        Swal.fire({
            title: 'Ingin keluar sekarang?',
            text: "Pastikan semua pekerjaan Anda sudah tersimpan ya, Ahyar!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '{{ $primary }}',
            cancelButtonColor: '#E5E7EB',
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: '<span style="color: #4B5563">Batal</span>',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-[2rem] shadow-2xl border-none',
                confirmButton: 'rounded-xl font-bold px-6 py-3',
                cancelButton: 'rounded-xl font-bold px-6 py-3'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form-dashboard').submit();
            }
        })
    }
</script>
@endsection