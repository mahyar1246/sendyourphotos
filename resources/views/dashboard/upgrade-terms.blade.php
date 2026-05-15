@php
    $currentTheme = session('user_theme', 'autumn');
    
    if ($currentTheme == 'forest') {
        $bg = '#E8F3E8'; $primary = '#2D5A27'; $secondary = '#1B3022';
    } elseif ($currentTheme == 'ocean') {
        $bg = '#E0F2F7'; $primary = '#076678'; $secondary = '#002B36';
    } else {
        $bg = '#F4ECE6'; $primary = '#C84B31'; $secondary = '#3E2723';
    }
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - SendYourPhotos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: {{ $bg }}; 
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 py-10 relative">

    <a href="{{ route('dashboard') }}" class="absolute top-6 left-6 md:top-10 md:left-10 flex items-center gap-2 text-gray-600 hover:text-[{{ $primary }}] font-bold transition-colors bg-white/50 px-4 py-2 rounded-full backdrop-blur-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Back to Dashboard
    </a>

    <div class="max-w-3xl w-full bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-gray-100 flex flex-col">
        
        <div class="bg-[{{ $primary }}] p-8 text-white text-center relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-black/10 rounded-full blur-2xl"></div>
            
            <div class="w-16 h-16 bg-white/20 rounded-2xl mx-auto flex items-center justify-center mb-4 backdrop-blur-sm border border-white/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
            </div>
            <h1 class="text-3xl font-bold mb-2">Distributor Agreement</h1>
            <p class="text-white/80 text-sm max-w-md mx-auto">Harap baca syarat dan ketentuan berikut dengan saksama sebelum mulai menjual foto di SendYourPhotos.</p>
        </div>

        <div class="p-8 md:p-10 max-h-[50vh] overflow-y-auto custom-scrollbar bg-gray-50/50">
            <div class="space-y-6">
                
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <h3 class="font-bold text-gray-900 text-lg mb-2 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-[{{ $primary }}]/10 text-[{{ $primary }}] flex items-center justify-center text-sm">1</span>
                        Orisinalitas & Hak Cipta
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed pl-8">
                        Setiap foto yang Anda unggah harus 100% merupakan hasil karya orisinal Anda. Anda dilarang keras mengunggah foto milik pihak lain, gambar dari internet, atau aset yang melanggar hak cipta kekayaan intelektual orang lain.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <h3 class="font-bold text-gray-900 text-lg mb-2 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-[{{ $primary }}]/10 text-[{{ $primary }}] flex items-center justify-center text-sm">2</span>
                        Kualitas Visual & Pengeditan
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed pl-8">
                        Foto wajib memiliki resolusi tinggi. Pengeditan gambar (seperti penyesuaian warna, ketajaman, dan penegasan struktur) diperbolehkan. Namun, hindari filter manipulatif berlebihan yang merusak tekstur dan keaslian visual dari foto tersebut.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <h3 class="font-bold text-gray-900 text-lg mb-2 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-[{{ $primary }}]/10 text-[{{ $primary }}] flex items-center justify-center text-sm">3</span>
                        Konten Aman
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed pl-8">
                        Platform kami menjunjung tinggi nilai keamanan dan kenyamanan. Karya Anda tidak boleh mengandung unsur pornografi, kekerasan ekstrem, ujaran kebencian, atau hal-hal yang bertentangan dengan hukum Republik Indonesia.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <h3 class="font-bold text-gray-900 text-lg mb-2 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-[{{ $primary }}]/10 text-[{{ $primary }}] flex items-center justify-center text-sm">4</span>
                        Bagi Hasil & Komisi
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed pl-8">
                        Sebagai Distributor, Anda akan menerima 80% dari total setiap transaksi yang berhasil. Sisa 20% dialokasikan untuk pemeliharaan server, biaya *payment gateway*, dan pengembangan platform SendYourPhotos.
                    </p>
                </div>

            </div>
        </div>

        <div class="p-8 border-t border-gray-100 bg-white">
            <form action="{{ route('upgrade.process') }}" method="POST">
                @csrf
                <label class="flex items-start gap-3 cursor-pointer group mb-6">
                    <div class="relative flex items-center">
                        <input type="checkbox" id="agree-checkbox" class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border-2 border-gray-300 checked:border-[{{ $primary }}] checked:bg-[{{ $primary }}] transition-all" required>
                        <span class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="1"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        </span>
                    </div>
                    <span class="text-sm font-medium text-gray-700 select-none group-hover:text-gray-900">
                        Saya telah membaca, memahami, dan menyetujui seluruh Syarat & Ketentuan di atas untuk menjadi Distributor di SendYourPhotos.
                    </span>
                </label>

                <button type="submit" id="submit-btn" class="w-full bg-gray-300 text-gray-500 font-bold text-lg py-4 rounded-xl transition-all duration-300 cursor-not-allowed flex items-center justify-center gap-2" disabled>
                    Setuju & Mulai Jualan
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </button>
            </form>
        </div>

    </div>

    <script>
        const checkbox = document.getElementById('agree-checkbox');
        const submitBtn = document.getElementById('submit-btn');

        checkbox.addEventListener('change', function() {
            if (this.checked) {
                // Aktifkan tombol
                submitBtn.disabled = false;
                submitBtn.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                submitBtn.classList.add('bg-[{{ $primary }}]', 'text-white', 'hover:bg-[{{ $secondary }}]', 'shadow-lg', 'active:scale-[0.98]');
            } else {
                // Nonaktifkan tombol
                submitBtn.disabled = true;
                submitBtn.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                submitBtn.classList.remove('bg-[{{ $primary }}]', 'text-white', 'hover:bg-[{{ $secondary }}]', 'shadow-lg', 'active:scale-[0.98]');
            }
        });
    </script>
</body>
</html>