<div class="p-6 max-w-7xl mx-auto">
    <div class="flex items-end justify-between mb-10">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Semua Materi Program Ini</h2>
        </div>
    </div>

    {{-- GRID PRODUK --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-4">
        
        @foreach([
            ['title' => 'Fullstack Mastery Laravel', 'img' => 'https://images.unsplash.com/photo-1547658719-da2b51169165?q=80&w=600'],
            ['title' => 'Agentic AI Development: Build the Future with Modern Frameworks', 'img' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?q=80&w=600'],
            ['title' => 'Flutter Mobile Pro: From Zero to Hero in 30 Days', 'img' => 'https://images.unsplash.com/photo-1617042375876-a13e36732a04?q=80&w=600']
        ] as $product)
        
        <div class="group flex flex-col bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden transition-all duration-500 hover:shadow-[0_20px_50px_rgb(0,0,0,0.1)] hover:-translate-y-2">
            
            {{-- Image Container --}}
            <div class="relative h-56 w-full overflow-hidden shrink-0">
                <div class="absolute inset-0 bg-slate-900/10 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <img src="{{ $product['img'] }}" 
                     alt="{{ $product['title'] }}" 
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            </div>

            {{-- Ganti bagian Content Container di dalam loop Anda dengan ini --}}

            <div class="p-8 flex flex-col flex-grow">
                
                {{-- Badge Kategori --}}
                <div class="mb-4">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-indigo-500 bg-indigo-50 px-3 py-1 rounded-full">
                        Kursus Premium
                    </span>
                </div>

                {{-- Title Container: Diberi tinggi tetap agar tombol selalu sejajar --}}
                {{-- Kita gunakan h-12 (48px) yang cukup untuk 2 baris teks dengan leading-tight --}}
                <div class="h-12 mb-6">
                    <h3 class="text-[17px] font-bold text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors line-clamp-2">
                        {{ $product['title'] }}
                    </h3>
                </div>
                
                {{-- Tombol: Tetap di bawah karena flex-grow pada parent --}}
                <div class="mt-auto pt-4 border-t border-slate-50">
                    <a href="#" class="flex items-center justify-center w-full py-3.5 bg-slate-900 text-white rounded-xl font-bold hover:bg-indigo-600 transition-all duration-300">
                        Lihat Materi
                    </a>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>