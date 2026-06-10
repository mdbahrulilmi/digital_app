<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <div class="lg:col-span-7 space-y-4">
        
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
            <input type="color" wire:model.live="editingContent.new_price_color" class="w-4 h-4 p-0 border-0 cursor-pointer rounded-sm">
            <span class="text-[10px] font-medium text-slate-600">Harga Coret</span>
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

        <div>
            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Pilih Produk Konten (Harga Diskon/Baru)</label>
            <select wire:model.live="editingContent.product_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-indigo-500">
                <option value="">-- Pilih Produk Berdasarkan Database --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} (Rp {{ number_format($product->price, 0, ',', '.') }})</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Harga Diskon</label>
                <input type="number" wire:model.live="editingContent.new_price" placeholder="Contoh: 150000" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Tulisan Badge</label>
                <input type="text" wire:model.live="editingContent.badge" placeholder="Contoh: SALE / Diskon 50%" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Teks Tombol</label>
                <input type="text" wire:model.live="editingContent.button_text" placeholder="Beli Sekarang" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-indigo-500">
            </div>
        </div>
    </div>

    <div class="lg:col-span-5 bg-slate-100 p-4 rounded-xl border border-slate-200 flex flex-col justify-center items-center min-h-[350px]">
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-3 align-self-start w-full">Pratinjau Relasi Produk:</span>
        
        @php
            $pFont        = $editingContent['font_family'] ?? 'font-sans';
            $pAlign       = $editingContent['alignment'] ?? 'text-left';
            $pColor       = $editingContent['text_color'] ?? '#1e293b';
            $pPrice       = $editingContent['price_color'] ?? '#4f46e5';
            $pNewPriceClr = $editingContent['new_price_color'] ?? '#94a3b8';
            $pBadgeBg     = $editingContent['badge_bg_color'] ?? '#f43f5e';
            $pBadgeTxt    = $editingContent['badge_text_color'] ?? '#ffffff';
            $pBtnBg       = $editingContent['btn_bg_color'] ?? '#4f46e5';
            $pBtnTxt      = $editingContent['btn_text_color'] ?? '#ffffff';

            $selectedProduct = !empty($editingContent['product_id']) 
                ? \App\Models\Product::find($editingContent['product_id']) 
                : null;
        @endphp

        <div class="w-full max-w-[280px] bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-md flex flex-col select-none {{ $pFont }} {{ $pAlign }}">
            
            <div class="relative w-full h-40 bg-slate-200 flex items-center justify-center overflow-hidden">
                @if($selectedProduct && $selectedProduct->image)
                    <img src="{{ asset($selectedProduct->image) }}" class="w-full h-full object-cover pointer-events-none">
                @else
                    <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 002-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                @endif

                @if(!empty($editingContent['badge']))
                    <span class="absolute top-3 left-3 font-bold text-[10px] px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm" style="background-color: {{ $pBadgeBg }}; color: {{ $pBadgeTxt }};">
                        {{ $editingContent['badge'] }}
                    </span>
                @endif
            </div>

            <div class="p-4 flex-1 flex flex-col space-y-1.5 h-48 overflow-hidden">
                <h4 class="font-bold text-base truncate" style="color: {{ $pColor }};">
                    {{ $selectedProduct ? $selectedProduct->name : 'Nama Produk Unggulan' }}
                </h4>
                
                <div class="flex flex-col gap-1 {{ $pAlign == 'text-center' ? 'items-center' : ($pAlign == 'text-right' ? 'items-end' : 'items-start') }}">
    
                    @if(!empty($editingContent['new_price']))
                        <span
                            class="text-sm font-medium line-through"
                            style="color: {{ $pNewPriceClr }};"
                        >
                            Rp {{ number_format($selectedProduct->price ?? 0, 0, ',', '.') }}
                        </span>

                        <span
                            class="text-lg font-black"
                            style="color: {{ $pPrice }};"
                        >
                            Rp {{ number_format($editingContent['new_price'], 0, ',', '.') }}
                        </span>
                    @else
                        <span
                            class="text-lg font-black"
                            style="color: {{ $pPrice }};"
                        >
                            Rp {{ number_format($selectedProduct->price ?? 0, 0, ',', '.') }}
                        </span>
                    @endif

                </div>
                
                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed flex-1">
                    {{ $selectedProduct ? $selectedProduct->description : 'Pilih produk dari database untuk memuat rincian deskripsi otomatis.' }}
                </p>

                <div class="pt-2">
                    <span class="w-full block text-center font-bold text-xs py-2 px-4 rounded-xl shadow transition pointer-events-none" style="background-color: {{ $pBtnBg }}; color: {{ $pBtnTxt }};">
                        {{ !empty($editingContent['button_text']) ? $editingContent['button_text'] : 'Beli' }}
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>