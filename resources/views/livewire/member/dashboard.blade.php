<div class="mx-auto p-6 md:p-8 space-y-10 font-sans">
    <section class="bg-indigo-700 rounded-3xl p-8 md:p-12 text-white shadow-2xl flex flex-col md:flex-row justify-between items-center gap-8 relative overflow-hidden">
        <div class="relative z-10 w-full">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Halo, {{ Auth::guard('member')->user()->name }}! 👋</h1>
            <p class="text-indigo-200 mt-2 text-lg">
                {{ $programUtama ? 'Lanjutkan progresmu di program ' . $programUtama->title : 'Segera mulai program pertamamu!' }}
            </p>
            
            @if($programUtama)
            <div class="mt-8 w-full md:w-96 bg-indigo-800/50 p-4 rounded-2xl border border-indigo-600">
                <div class="flex justify-between text-[10px] font-black mb-2 uppercase tracking-widest text-indigo-300">
                    <span>{{'Program ' . $programUtama->title }}</span>
                    <span>{{ round($progresPersen) }}%</span>
                </div>
                <div class="w-full bg-indigo-900 rounded-full h-2.5">
                    <div class="bg-emerald-400 h-2.5 rounded-full shadow-[0_0_10px_rgba(52,211,153,0.5)]" 
                        style="width: {{ $progresPersen }}%"></div>
                </div>
            </div>
            @endif
        </div>
        
        <button class="relative z-10 w-full md:w-auto bg-white text-indigo-700 font-bold py-4 px-10 rounded-2xl hover:scale-105 transition-transform shadow-lg whitespace-nowrap">
            LANJUTKAN SESI
        </button>
    </section>

    <section class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-orange-50 border border-orange-100 rounded-3xl p-6 flex items-center gap-4">
            <div class="text-2xl">🔥</div>
            <div>
                <p class="text-[10px] text-orange-600 font-extrabold uppercase tracking-widest">Streak</p>
                <p class="text-xl font-black text-orange-900">{{ $stats['streak'] }} Hari</p>
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition">
            <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest">Program Selesai</p>
            <p class="text-xl font-black text-slate-900 mt-1">{{ $stats['program_selesai'] }}</p>
        </div>
        
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition">
            <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest">Total Program</p>
            <p class="text-xl font-black text-slate-900 mt-1">{{ $stats['total_program'] }}</p>
        </div>

        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition">
            <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest">Total Produk</p>
            <p class="text-xl font-black text-slate-900 mt-1">{{ $stats['total_produk'] }}</p>
        </div>
    </section>

    @if($programs->isNotEmpty())
    <section>
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-black text-slate-900 border-l-4 border-indigo-600 pl-4">Program Terbaru</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($programs as $prog)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition overflow-hidden group cursor-pointer">
                    <div class="relative h-48 w-full overflow-hidden">
                        <img src="{{ $prog->image }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <p class="font-bold text-lg leading-tight">{{ $prog->title }}</p>
                        </div>
                    </div>

                    <div class="p-4">
                        <p class="text-sm text-slate-500 line-clamp-2 mb-4">{{ $prog->description }}</p>
                        
                        <div class="flex justify-end">
                            <a href="{{ $prog->slug }}" 
                            class="cursor-pointer text-[10px] font-black uppercase tracking-widest bg-indigo-600 text-white px-4 py-2 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 border border-indigo-600 transition-colors">
                                Cari Tahu
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif
    @if($products->isNotEmpty())
    <section>
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-black text-slate-900 border-l-4 border-orange-500 pl-4">Produk Pilihan</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($products as $prod)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition overflow-hidden group cursor-pointer">
                    <div class="relative h-48 w-full overflow-hidden">
                        <img src="{{ $prod->image }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <p class="font-bold text-lg leading-tight">{{ $prod->title }}</p>
                        </div>
                    </div>

                    <div class="p-4">
                        <p class="text-sm text-slate-500 line-clamp-2 mb-4">{{ $prod->description }}</p>
                        
                        <div class="flex justify-end">
                            <a href="{{ route('public.product.show', $prod->slug) }}" 
                            wire:navigate
                            class="cursor-pointer text-[10px] font-black uppercase tracking-widest bg-indigo-600 text-white px-4 py-2 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 border border-indigo-600 transition-colors">
                                Beli Produk
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif
    @if($blogs->isNotEmpty())
    <section>
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-black text-slate-900 border-l-4 border-teal-500 pl-4">Artikel Blog</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($blogs as $blog)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition overflow-hidden group cursor-pointer">
                @php
                    $firstImageSection = $blog->sections->first();
                    
                    $content = $firstImageSection ? $firstImageSection->content : null;
                    
                    $imageUrl = is_array($content) ? ($content['image_url'] ?? null) : null;
                @endphp
                <div class="h-40 bg-slate-200 flex items-center justify-center">
                    @if($imageUrl)
                        <img src="{{ $imageUrl }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div class="flex items-center justify-center h-full text-slate-400 text-xs">No Image</div>
                    @endif
                </div>
                
                <div class="p-4">
                    <p class="text-sm font-bold text-slate-800 leading-tight mb-2">
                        {{ $blog->title }}
                    </p>
                    <p class="text-xs text-slate-500 line-clamp-2">
                        {{ $blog->description }}
                    </p>
                    
                    <div class="mt-4 flex justify-end">
                        <a href="{{ $prog->slug }}"  class="text-[10px] font-black uppercase tracking-widest text-teal-600 hover:text-teal-700 transition">
                                Lihat Selengkapnya
                            </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>