@php
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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout - SendYourPhotos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: {{ $bg }}; 
            transition: background-color 0.5s ease;
        }
    </style>
</head>
<body class="antialiased text-gray-900">

    <!-- NAVBAR MINIMALIS (KHUSUS CHECKOUT) -->
    <nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('photo.show', $photo->id) }}" class="flex items-center gap-2 text-gray-500 hover:text-[{{ $primary }}] transition-colors font-bold text-sm bg-gray-50 hover:bg-gray-100 px-4 py-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Back to Photo
                </a>
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[{{ $primary }}]" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                    <span class="text-sm font-black text-[{{ $primary }}] uppercase tracking-widest">Secure Checkout</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
        <h1 class="text-3xl md:text-4xl font-extrabold text-[{{ $secondary }}] mb-2 tracking-tight">Complete your purchase</h1>
        <p class="text-gray-500 font-medium mb-10">Select a payment method to unlock your high-resolution image.</p>

        <div class="flex flex-col lg:flex-row gap-10 items-start">
            
            <!-- FORM METODE PEMBAYARAN -->
            <div class="w-full lg:w-2/3 space-y-8">
                <div class="bg-white p-8 md:p-10 rounded-[2rem] shadow-sm border border-gray-100 border-t-8 border-t-[{{ $primary }}]">
                    <h2 class="text-xl font-bold text-[{{ $secondary }}] mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[{{ $primary }}]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                        Payment Method
                    </h2>
                    
                    <form action="{{ route('checkout.process', $photo->id) }}" method="POST" id="payment-form">
                        @csrf
                        <div class="space-y-4">
                            
                            <!-- Opsi Bank Transfer -->
                            <label class="flex items-center justify-between p-5 border-2 border-[{{ $primary }}] bg-[{{ $light }}]/30 rounded-2xl cursor-pointer transition-all hover:shadow-md relative overflow-hidden group">
                                <div class="absolute inset-y-0 left-0 w-1.5 bg-[{{ $primary }}]"></div>
                                <div class="flex items-center gap-4 pl-2">
                                    <input type="radio" name="payment_method" value="bank_transfer" checked class="w-5 h-5 text-[{{ $primary }}] focus:ring-[{{ $primary }}]">
                                    <div>
                                        <p class="font-bold text-gray-900 text-lg">Bank Transfer (Virtual Account)</p>
                                        <p class="text-sm text-gray-500 mt-1">BCA, Mandiri, BNI, BRI</p>
                                    </div>
                                </div>
                            </label>

                            <!-- Opsi E-Wallet -->
                            <label class="flex items-center justify-between p-5 border-2 border-gray-100 hover:border-[{{ $primary }}]/50 rounded-2xl cursor-pointer transition-all hover:bg-gray-50">
                                <div class="flex items-center gap-4 pl-3.5">
                                    <input type="radio" name="payment_method" value="ewallet" class="w-5 h-5 text-[{{ $primary }}] focus:ring-[{{ $primary }}]">
                                    <div>
                                        <p class="font-bold text-gray-900 text-lg">E-Wallet (QRIS)</p>
                                        <p class="text-sm text-gray-500 mt-1">GoPay, OVO, Dana, ShopeePay</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Info Pengiriman -->
                        <div class="mt-10 pt-8 border-t border-gray-100">
                            <h2 class="text-lg font-bold text-[{{ $secondary }}] mb-3">Delivery Info</h2>
                            <p class="text-sm text-gray-500 mb-4 leading-relaxed">The high-resolution photo without watermark will be automatically accessible in your Dashboard upon successful payment. A digital receipt will be sent to:</p>
                            <div class="bg-[{{ $bg }}] p-4 rounded-xl border border-[{{ $borderLight }}] flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg>
                                <p class="font-bold text-[{{ $secondary }}]">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- RINGKASAN PESANAN (KARTU KANAN) -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white p-8 rounded-[2rem] shadow-2xl shadow-[{{ $primary }}]/10 border border-gray-100 sticky top-28">
                    <h2 class="text-xl font-black text-[{{ $secondary }}] mb-6">Order Summary</h2>
                    
                    <div class="flex gap-4 mb-6 pb-6 border-b border-gray-100">
                        <div class="w-24 h-24 rounded-2xl overflow-hidden bg-[{{ $light }}] shrink-0 border border-gray-100 shadow-sm">
                            <img src="{{ asset('storage/' . $photo->file_path) }}" alt="{{ $photo->title }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col justify-center">
                            <span class="text-[10px] font-black text-white bg-[{{ $primary }}] px-2 py-1 rounded w-max mb-2 uppercase tracking-widest shadow-sm shadow-[{{ $primary }}]/30">Standard License</span>
                            <h3 class="font-bold text-gray-900 leading-tight mb-1 line-clamp-2">{{ $photo->title }}</h3>
                            <p class="text-xs text-gray-500 font-medium">By {{ $photo->user->name ?? 'Creator' }}</p>
                        </div>
                    </div>

                    <div class="space-y-4 mb-6 text-sm">
                        <div class="flex justify-between text-gray-500 font-medium">
                            <span>Subtotal</span>
                            <span class="text-gray-900 font-bold">Rp {{ number_format($photo->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-500 font-medium">
                            <span>Platform Fee (0%)</span>
                            <span class="text-gray-900 font-bold">Rp 0</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-8 pt-6 border-t border-gray-100">
                        <span class="text-lg font-black text-gray-900">Total Due</span>
                        <span class="text-3xl font-black text-[{{ $primary }}]">
                            Rp {{ number_format($photo->price, 0, ',', '.') }}
                        </span>
                    </div>

                    <button type="submit" form="payment-form" class="w-full bg-[{{ $primary }}] text-white font-black text-lg px-8 py-4 rounded-xl hover:bg-[{{ $hover }}] transition-all active:scale-[0.98] shadow-xl shadow-[{{ $primary }}]/30 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                        Pay & Download
                    </button>
                    
                    <div class="flex items-start gap-2 mt-6 p-4 bg-gray-50 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                        <p class="text-xs text-gray-500 leading-relaxed font-medium">By completing this purchase, you agree to our Terms of Service and Licensing Agreement.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>