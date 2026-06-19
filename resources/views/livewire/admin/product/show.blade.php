<div class="max-w-5xl mx-auto px-4 py-8">
    
    {{-- ALERT ERROR --}}
    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-rose-100 text-rose-800 rounded-2xl font-medium flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- TOMBOL KEMBALI --}}
    <div class="mb-6">
        <a href="{{ route('product.list') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Produk
        </a>
    </div>

    {{-- CARD DETAIL PRODUK --}}
    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm grid grid-cols-1 md:grid-cols-12 gap-8 p-6 md:p-8">
        
        {{-- BAGIAN KIRI: PREVIEW GAMBAR (40% Lebar Kolom) --}}
        <div class="md:col-span-5 space-y-4">
            <div class="aspect-square bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 shadow-inner">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 stroke-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 002-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-xs mt-2 font-medium">Tidak ada gambar</span>
                    </div>
                @endif
            </div>

            {{-- BADGE STATUS --}}
            <div class="flex justify-center">
                @if($product->status === 'active')
                    <span class="px-3 py-1 text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full">● Produk Aktif</span>
                @else
                    <span class="px-3 py-1 text-xs font-semibold bg-slate-50 text-slate-500 border border-slate-200 rounded-full">● Non-Aktif</span>
                @endif
            </div>
        </div>

        {{-- BAGIAN KANAN: DETAIL DATA PRODUK (60% Lebar Kolom) --}}
        <div class="md:col-span-7 flex flex-col justify-between space-y-6">
            
            <div class="space-y-4">
                {{-- NAMA & HARGA --}}
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $product->name }}</h1>
                    <p class="text-2xl font-bold text-indigo-600 mt-2">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                </div>

                <hr class="border-slate-100">

                {{-- DESKRIPSI --}}
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider">Deskripsi Produk</h3>
                    <p class="text-slate-600 text-sm mt-1 leading-relaxed whitespace-pre-line">
                        {{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}
                    </p>
                </div>
            </div>

            {{-- PANEL ACTIONS / DOWNLOAD DIGITAL ASSET --}}
            <div class="pt-6 border-t border-slate-100 bg-slate-50 -mx-6 -mb-6 p-6 md:-mx-8 md:-mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    
                    {{-- Info metadata file --}}
                    <div>
                        <span class="text-xs font-semibold text-slate-400 block uppercase tracking-wider">Aset Digital</span>
                        @php
                            $asset = is_string($product->digital_assets) ? json_decode($product->digital_assets, true) : $product->digital_assets;
                        @endphp

                        @if($asset)
                            <div class="flex items-center gap-2 mt-1 text-sm font-semibold text-slate-800">
                                @if(isset($asset['type']) && $asset['type'] === 'link')
                                    <span class="text-indigo-600 truncate max-w-[220px]">🔗 {{ $asset['url'] }}</span>
                                @else
                                    <span class="truncate max-w-[220px]">📄 {{ $asset['name'] ?? 'File Terlampir' }}</span>
                                @endif
                            </div>
                        @else
                            <span class="text-sm text-slate-400 italic block mt-0.5">Belum ada aset.</span>
                        @endif
                    </div>

                    {{-- Tombol Aksi --}}
                    <div>
                        @if($asset)
                            <button 
                                wire:click="downloadAsset"
                                wire:loading.attr="disabled"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl transition group">
                                
                                {{-- Ubah teks tombol berdasarkan tipe --}}
                                <span wire:loading.remove wire:target="downloadAsset">
                                    {{ (isset($asset['type']) && $asset['type'] === 'link') ? 'Buka Link Aset' : 'Unduh File Asset' }}
                                </span>
                                <span wire:loading wire:target="downloadAsset">Memproses...</span>
                            </button>
                        @else
                            <button disabled class="px-6 py-3 bg-slate-200 text-slate-400 font-bold rounded-2xl cursor-not-allowed">
                                Tidak Tersedia
                            </button>
                        @endif
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>