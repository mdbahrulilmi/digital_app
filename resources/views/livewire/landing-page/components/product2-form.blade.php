<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    {{-- LEFT EDITOR --}}
    <div class="lg:col-span-7 space-y-4 max-h-[80vh] overflow-y-auto pr-2">

        {{-- TOOLBAR STYLE & PENGATURAN WARNA --}}
        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 flex flex-wrap gap-3 items-center">
            
            <div class="flex items-center gap-1">
                <label class="text-[10px] font-bold text-slate-500 uppercase">Font:</label>
                <select wire:model.live="editingContent.font_family" class="text-xs border border-slate-200 rounded p-1 bg-white">
                    <option value="font-sans">Sans (Modern)</option>
                    <option value="font-serif">Serif (Klasik)</option>
                    <option value="font-mono">Mono</option>
                </select>
            </div>

            <div class="flex items-center gap-1">
                <label class="text-[10px] font-bold text-slate-500 uppercase">Posisi:</label>
                <select wire:model.live="editingContent.alignment" class="text-xs border border-slate-200 rounded p-1 bg-white">
                    <option value="text-left">Kiri</option>
                    <option value="text-center">Tengah</option>
                    <option value="text-right">Kanan</option>
                </select>
            </div>

            <div class="h-4 w-px bg-slate-300"></div>

            {{-- Palet Warna Ber-Label --}}
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-[10px] font-bold text-slate-500 uppercase block w-full md:w-auto mb-1 md:mb-0">Pengaturan Warna:</span>
                
                <div class="flex flex-wrap gap-2 items-center">
                    <label class="cursor-pointer flex items-center gap-1.5 bg-white border border-slate-200 rounded px-2 py-1 shadow-sm hover:bg-slate-50 transition">
                        <input type="color" wire:model.live="editingContent.text_color" class="w-4 h-4 p-0 border-0 cursor-pointer rounded-sm">
                        <span class="text-[10px] font-medium text-slate-600">Teks/Judul</span>
                    </label>
                    
                    <label class="cursor-pointer flex items-center gap-1.5 bg-white border border-slate-200 rounded px-2 py-1 shadow-sm hover:bg-slate-50 transition">
                        <input type="color" wire:model.live="editingContent.price_color" class="w-4 h-4 p-0 border-0 cursor-pointer rounded-sm">
                        <span class="text-[10px] font-medium text-slate-600">Harga Baru</span>
                    </label>

                    <label class="cursor-pointer flex items-center gap-1.5 bg-white border border-slate-200 rounded px-2 py-1 shadow-sm hover:bg-slate-50 transition">
                        <input type="color" wire:model.live="editingContent.badge_bg_color" class="w-4 h-4 p-0 border-0 cursor-pointer rounded-sm">
                        <span class="text-[10px] font-medium text-slate-600">BG Badge</span>
                    </label>
                    
                    <label class="cursor-pointer flex items-center gap-1.5 bg-white border border-slate-200 rounded px-2 py-1 shadow-sm hover:bg-slate-50 transition">
                        <input type="color" wire:model.live="editingContent.badge_text_color" class="w-4 h-4 p-0 border-0 cursor-pointer rounded-sm">
                        <span class="text-[10px] font-medium text-slate-600">Teks Badge</span>
                    </label>
                    
                    <label class="cursor-pointer flex items-center gap-1.5 bg-white border border-slate-200 rounded px-2 py-1 shadow-sm hover:bg-slate-50 transition">
                        <input type="color" wire:model.live="editingContent.btn_bg_color" class="w-4 h-4 p-0 border-0 cursor-pointer rounded-sm">
                        <span class="text-[10px] font-medium text-slate-600">BG Tombol</span>
                    </label>
                    
                    <label class="cursor-pointer flex items-center gap-1.5 bg-white border border-slate-200 rounded px-2 py-1 shadow-sm hover:bg-slate-50 transition">
                        <input type="color" wire:model.live="editingContent.btn_text_color" class="w-4 h-4 p-0 border-0 cursor-pointer rounded-sm">
                        <span class="text-[10px] font-medium text-slate-600">Teks Tombol</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- SELEKSI KONTEN PRODUK & BADGE Masing-masing --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- PRODUCT 1 CONFIG --}}
            <div class="p-4 bg-white border border-slate-200 rounded-xl space-y-3 shadow-sm">
                <h4 class="text-xs font-extrabold text-indigo-600 uppercase border-b pb-1">
                    Produk Kiri (1)
                </h4>
                <div>
                    <label class="block text-[11px] font-medium text-slate-500 mb-1">Database Produk:</label>
                    <select wire:model.live="editingContent.product_id_1" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-indigo-500">
                        <option value="">-- Pilih Produk 1 --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} (Rp {{ number_format($product->price, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-slate-500 mb-1">Badge Produk Kiri:</label>
                    <input type="text" wire:model.live="editingContent.badge_1" placeholder="Contoh: SALE / -10%" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-indigo-500">
                </div>
            </div>

            {{-- PRODUCT 2 CONFIG --}}
            <div class="p-4 bg-white border border-slate-200 rounded-xl space-y-3 shadow-sm">
                <h4 class="text-xs font-extrabold text-indigo-600 uppercase border-b pb-1">
                    Produk Kanan (2)
                </h4>
                <div>
                    <label class="block text-[11px] font-medium text-slate-500 mb-1">Database Produk:</label>
                    <select wire:model.live="editingContent.product_id_2" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-indigo-500">
                        <option value="">-- Pilih Produk 2 --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} (Rp {{ number_format($product->price, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-slate-500 mb-1">Badge Produk Kanan:</label>
                    <input type="text" wire:model.live="editingContent.badge_2" placeholder="Contoh: NEW / Hot" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-indigo-500">
                </div>
            </div>
        </div>

        {{-- INPUT TEKS TOMBOL GLOBAL --}}
        <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Teks Tombol Aksi</label>
            <input type="text" wire:model.live="editingContent.button_text" placeholder="Contoh: Masukkan Keranjang / Beli Sekarang" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-indigo-500">
        </div>

    </div>

    {{-- RIGHT PREVIEW (Tampilan Grid 2 Kolom Fix Align Kiri untuk Detail) --}}
    <div class="lg:col-span-5 bg-slate-100 p-4 rounded-xl border border-slate-200 flex flex-col justify-center items-center min-h-[350px]">
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-3 align-self-start w-full">Pratinjau Relasi Produk (Double):</span>

        @php
            $pFont     = $editingContent['font_family'] ?? 'font-sans';
            $pAlign    = $editingContent['alignment'] ?? 'text-left'; // Default left sesuai instruksi detail konten
            $pColor    = $editingContent['text_color'] ?? '#1e293b';
            $pPrice    = $editingContent['price_color'] ?? '#4f46e5';
            $pBadgeBg  = $editingContent['badge_bg_color'] ?? '#f43f5e';
            $pBadgeTxt = $editingContent['badge_text_color'] ?? '#ffffff';
            $pBtnBg    = $editingContent['btn_bg_color'] ?? '#4f46e5';
            $pBtnTxt   = $editingContent['btn_text_color'] ?? '#ffffff';

            $product1 = !empty($editingContent['product_id_1'])
                ? \App\Models\Product::find($editingContent['product_id_1'])
                : null;

            $product2 = !empty($editingContent['product_id_2'])
                ? \App\Models\Product::find($editingContent['product_id_2'])
                : null;
        @endphp

        <div class="w-full grid grid-cols-2 gap-3 {{ $pFont }} {{ $pAlign }}">

            {{-- CARD PREVIEW PRODUCT 1 --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col h-[230px] select-none">
                {{-- Gambar Besar Fix --}}
                <div class="relative h-24 min-h-[96px] w-full bg-slate-200 flex items-center justify-center overflow-hidden">
                    @if($product1 && $product1->image)
                        <img src="{{ asset($product1->image) }}" class="w-full h-full object-cover pointer-events-none">
                    @else
                        <span class="text-[10px] text-slate-400 font-medium">No Image</span>
                    @endif

                    {{-- Badge Kiri Kustom --}}
                    @if(!empty($editingContent['badge_1']))
                        <span class="absolute top-1.5 left-1.5 font-bold text-[8px] px-1.5 py-0.5 rounded uppercase tracking-wide shadow-sm max-w-[80%] truncate whitespace-nowrap" 
                              style="background-color: {{ $pBadgeBg }}; color: {{ $pBadgeTxt }};">
                            {{ $editingContent['badge_1'] }}
                        </span>
                    @endif
                </div>

                <div class="p-2 flex flex-col flex-1 justify-between min-w-0">
                    <div class="min-w-0 space-y-0.5">
                        {{-- Nama Mengecil Otomatis & No-Wrap --}}
                        <h3 class="font-bold whitespace-nowrap truncate" 
                            style="color: {{ $pColor }}; font-size: clamp(9px, 2vw, 11px); min-height: 16px;">
                            {{ $product1->name ?? 'Produk 1' }}
                        </h3>
                        <div class="text-[11px] font-black tracking-tight truncate" style="color: {{ $pPrice }};">
                            {{ $product1 ? 'Rp ' . number_format($product1->price, 0, ',', '.') : 'Rp 0' }}
                        </div>
                        <p class="text-[9px] text-slate-500 line-clamp-2 leading-tight">
                            {{ $product1->description ?? 'Pilih produk dari database' }}
                        </p>
                    </div>

                    <div class="pt-1">
                        <span class="w-full block text-center font-bold text-[9px] py-1 px-1 rounded shadow-sm pointer-events-none truncate"
                            style="background-color: {{ $pBtnBg }}; color: {{ $pBtnTxt }};">
                            {{ $editingContent['button_text'] ?? 'Beli' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- CARD PREVIEW PRODUCT 2 --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col h-[230px] select-none">
                {{-- Gambar Besar Fix --}}
                <div class="relative h-24 min-h-[96px] w-full bg-slate-200 flex items-center justify-center overflow-hidden">
                    @if($product2 && $product2->image)
                        <img src="{{ asset($product2->image) }}" class="w-full h-full object-cover pointer-events-none">
                    @else
                        <span class="text-[10px] text-slate-400 font-medium">No Image</span>
                    @endif

                    {{-- Badge Kanan Kustom --}}
                    @if(!empty($editingContent['badge_2']))
                        <span class="absolute top-1.5 left-1.5 font-bold text-[8px] px-1.5 py-0.5 rounded uppercase tracking-wide shadow-sm max-w-[80%] truncate whitespace-nowrap" 
                              style="background-color: {{ $pBadgeBg }}; color: {{ $pBadgeTxt }};">
                            {{ $editingContent['badge_2'] }}
                        </span>
                    @endif
                </div>

                <div class="p-2 flex flex-col flex-1 justify-between min-w-0">
                    <div class="min-w-0 space-y-0.5">
                        {{-- Nama Mengecil Otomatis & No-Wrap --}}
                        <h3 class="font-bold whitespace-nowrap truncate" 
                            style="color: {{ $pColor }}; font-size: clamp(9px, 2vw, 11px); min-height: 16px;">
                            {{ $product2->name ?? 'Produk 2' }}
                        </h3>
                        <div class="text-[11px] font-black tracking-tight truncate" style="color: {{ $pPrice }};">
                            {{ $product2 ? 'Rp ' . number_format($product2->price, 0, ',', '.') : 'Rp 0' }}
                        </div>
                        <p class="text-[9px] text-slate-500 line-clamp-2 leading-tight">
                            {{ $product2->description ?? 'Pilih produk dari database' }}
                        </p>
                    </div>

                    <div class="pt-1">
                        <span class="w-full block text-center font-bold text-[9px] py-1 px-1 rounded shadow-sm pointer-events-none truncate"
                            style="background-color: {{ $pBtnBg }}; color: {{ $pBtnTxt }};">
                            {{ $editingContent['button_text'] ?? 'Beli' }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>