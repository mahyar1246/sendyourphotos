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
    <title>Upload Photo - SendYourPhotos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: {{ $bg }};
            transition: background-color 0.5s ease;
        }
    </style>
</head>
<body class="p-4 md:p-6 h-screen overflow-hidden flex justify-center items-center">

    <div class="w-full max-w-[1200px] h-[90vh] bg-white rounded-[2rem] shadow-2xl overflow-hidden flex flex-col relative border-[8px] border-white/50">
        
        <header class="px-8 py-5 flex justify-between items-center border-b border-gray-100 z-10 bg-white">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-[{{ $primary }}] hover:bg-[{{ $primary }}] hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="font-bold text-gray-800 text-xl tracking-tight">Upload New Masterpiece</h1>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-[{{ $bg }}]/30">
            <div class="max-w-5xl mx-auto bg-white rounded-[1.5rem] p-8 lg:p-10 border border-gray-100 shadow-sm">
                
                @if ($errors->any())
                    <div class="bg-red-50 text-red-500 p-4 rounded-xl mb-6 text-sm border border-red-100">
                        <ul class="list-disc pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('upload.post') }}" method="POST" enctype="multipart/form-data" class="flex flex-col lg:flex-row gap-10">
                    @csrf

                    <div class="w-full lg:w-5/12 flex flex-col">
                        <label class="block text-sm font-semibold text-gray-800 mb-3">Photo File</label>
                        
                        <div id="dropzoneContainer" class="group relative flex-1 flex flex-col justify-center px-6 py-10 border-2 border-gray-200 border-dashed rounded-[1.5rem] hover:border-[{{ $primary }}] hover:bg-[{{ $bg }}]/50 transition-all duration-300 cursor-pointer min-h-[350px] overflow-hidden bg-gray-50">
                            
                            <img id="imagePreview" src="#" alt="Preview" class="opacity-0 absolute inset-0 w-full h-full object-cover z-10 transition-opacity duration-500 pointer-events-none" />

                            <div id="dropzoneContent" class="space-y-3 text-center z-0 transition-opacity duration-300">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto shadow-sm text-gray-400 group-hover:text-[{{ $primary }}] group-hover:scale-110 transition-transform duration-300">
                                    <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="flex flex-col text-sm text-gray-600 justify-center">
                                    <span class="font-bold text-[{{ $primary }}]">Click to browse</span>
                                    <span class="text-gray-500">or drag and drop here</span>
                                </div>
                                <p class="text-xs text-gray-400 font-medium">High-Res PNG, JPG up to 10MB</p>
                            </div>

                            <input id="photo" name="photo" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" accept="image/png, image/jpeg, image/jpg" onchange="previewImage(event)" required>
                        </div>
                        
                        <div id="fileDetailsPanel" class="hidden mt-4 bg-white border border-gray-100 rounded-xl p-3 shadow-sm flex items-center justify-between z-30">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <div class="w-10 h-10 bg-gray-50 text-[{{ $primary }}] rounded-lg flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="truncate">
                                    <p id="fileName" class="text-sm font-bold text-gray-800 truncate">filename.jpg</p>
                                    <p id="fileSize" class="text-xs text-gray-500">2.5 MB</p>
                                </div>
                            </div>
                            
                            <button type="button" onclick="removeImage()" class="w-8 h-8 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-full flex items-center justify-center shrink-0 transition-colors" title="Remove Photo">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="w-full lg:w-7/12 flex flex-col space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Photo Title</label>
                            <input type="text" name="title" placeholder="Give your masterpiece a catchy name..." class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:border-[{{ $primary }}] outline-none transition-all bg-gray-50 hover:bg-white focus:bg-white text-gray-900" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Description / Story</label>
                            <textarea name="description" rows="4" placeholder="Where was it taken? What is the story behind this shot?..." class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:border-[{{ $primary }}] outline-none transition-all bg-gray-50 hover:bg-white focus:bg-white resize-none text-gray-900" required></textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-6">
                            <div class="w-full sm:w-1/2">
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Category</label>
                                <select name="category_id" class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:border-[{{ $primary }}] outline-none transition-all bg-gray-50 hover:bg-white focus:bg-white text-gray-700 appearance-none cursor-pointer" required>
                                    <option value="" disabled selected>Select a category</option>
                                    <option value="1">Nature & Landscapes</option>
                                    <option value="2">Architecture & Urban</option>
                                    <option value="3">People & Portraits</option>
                                </select>
                            </div>
                            <div class="w-full sm:w-1/2">
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Price (Rupiah)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-bold">Rp</span>
                                    </div>
                                    <input type="number" name="price" placeholder="50000" class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 focus:border-[{{ $primary }}] outline-none transition-all bg-gray-50 hover:bg-white focus:bg-white text-gray-900 font-semibold" required>
                                </div>
                            </div>
                        </div>

                        <div class="flex-1"></div>

                        <div class="pt-4 border-t border-gray-100">
                            <button type="submit" class="w-full bg-[{{ $secondary }}] text-white font-bold text-lg px-8 py-4 rounded-xl hover:bg-[{{ $primary }}] hover:shadow-lg transition-all duration-300 active:scale-[0.98] flex items-center justify-center gap-3 group">
                                Publish to Gallery
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- SCRIPT IMAGE PREVIEW DRAG & DROP -->
 <script src="{{ asset('js/upload.js') }}"></script>
    
</body>
</html>