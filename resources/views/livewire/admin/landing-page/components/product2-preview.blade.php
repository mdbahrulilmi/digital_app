@php
    $content = $section->content ?? [];

    $fontFamily   = $content['font_family'] ?? 'font-sans';
    $alignment    = $content['alignment'] ?? 'text-left'; 
    $textColor    = $content['text_color'] ?? '#1e293b';
    $priceColor   = $content['price_color'] ?? '#e11d48'; 
    $badgeBg      = $content['badge_bg_color'] ?? '#f43f5e';
    $badgeTxt     = $content['badge_text_color'] ?? '#ffffff';
    $btnBgColor   = $content['btn_bg_color'] ?? '#4f46e5';
    $btnTextColor = $content['btn_text_color'] ?? '#ffffff';

    $p1Id    = $content['product_id_1'] ?? ('p1-' . $section->id);
    $p1Title = $content['title_1'] ?? 'Produk 1';
    $p1Price = $content['price_1'] ?? 0;
    $p1Desc  = $content['description_1'] ?? '';
    $p1Img   = $content['image_url_1'] ?? null;
    $p1Badge = $content['badge_1'] ?? null;

    $p2Id    = $content['product_id_2'] ?? ('p2-' . $section->id);
    $p2Title = $content['title_2'] ?? 'Produk 2';
    $p2Price = $content['price_2'] ?? 0;
    $p2Desc  = $content['description_2'] ?? '';
    $p2Img   = $content['image_url_2'] ?? null;
    $p2Badge = $content['badge_2'] ?? null;

    $btnText = $content['button_text'] ?? 'Beli';
@endphp

<div class="py-3 px-2 bg-white flex justify-center">
    <div class="w-full max-w-5xl grid grid-cols-2 gap-2 md:gap-4 {{ $fontFamily }} {{ $alignment }}">
        
        {{-- CARD PRODUCT 1 (KIRI) --}}
        <div class="bg-white rounded-lg overflow-hidden border border-slate-100 shadow-sm flex flex-col justify-between min-w-0">
            <div>
                {{-- Kontainer Gambar --}}
                <div class="relative w-full aspect-square bg-slate-50 flex items-center justify-center overflow-hidden">
                    @if(!empty($p1Img))
                        <img src="{{ asset($p1Img) }}" alt="{{ $p1Title }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 002-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    @endif

                    {{-- Badge Kiri --}}
                    @if(!empty($p1Badge))
                        <span class="absolute top-1.5 left-1.5 font-extrabold text-[9px] px-1.5 py-0.5 rounded shadow-sm uppercase tracking-wider max-w-[85%] truncate whitespace-nowrap"
                              style="background-color: {{ $badgeBg }}; color: {{ $badgeTxt }};">
                            {{ $p1Badge }}
                        </span>
                    @endif
                </div>

                <div class="p-2 space-y-1 min-w-0">
                    {{-- Judul --}}
                    <h3 class="font-bold whitespace-nowrap truncate leading-tight" 
                        style="color: {{ $textColor }}; font-size: clamp(10px, 2.5vw, 14px); min-height: 18px;">
                        {{ $p1Title }}
                    </h3>
                    
                    {{-- Harga --}}
                    <div class="text-xs md:text-sm font-black tracking-tight truncate" style="color: {{ $priceColor }};">
                        Rp {{ number_format($p1Price, 0, ',', '.') }}
                    </div>

                    {{-- Deskripsi --}}
                    <p class="text-[9px] md:text-xs text-slate-400 line-clamp-1 leading-none truncate">
                        {{ strip_tags($p1Desc) }}
                    </p>
                </div>
            </div>

            <div class="p-2 pt-0">
                {{-- Tombol Keranjang Livewire Produk 1 --}}
                <button type="button" 
                    wire:click="addToCart('{{ $p1Id }}', '{{ addslashes($p1Title) }}', {{ $p1Price }}, 'product')"
                    x-on:click="$dispatch('cartUpdated')"
                    class="w-full block text-center font-bold text-[10px] md:text-xs py-1.5 px-2 rounded-md transition duration-150 transform active:scale-95 shadow-sm truncate cursor-pointer"
                    style="background-color: {{ $btnBgColor }}; color: {{ $btnTextColor }};">
                    {{ $btnText }}
                </button>
            </div>
        </div>

        {{-- CARD PRODUCT 2 (KANAN) --}}
        <div class="bg-white rounded-lg overflow-hidden border border-slate-100 shadow-sm flex flex-col justify-between min-w-0">
            <div>
                {{-- Kontainer Gambar --}}
                <div class="relative w-full aspect-square bg-slate-50 flex items-center justify-center overflow-hidden">
                    @if(!empty($p2Img))
                        <img src="{{ asset($p2Img) }}" alt="{{ $p2Title }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 002-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    @endif

                    {{-- Badge Kanan --}}
                    @if(!empty($p2Badge))
                        <span class="absolute top-1.5 left-1.5 font-extrabold text-[9px] px-1.5 py-0.5 rounded shadow-sm uppercase tracking-wider max-w-[85%] truncate whitespace-nowrap"
                              style="background-color: {{ $badgeBg }}; color: {{ $badgeTxt }};">
                            {{ $p2Badge }}
                        </span>
                    @endif
                </div>

                <div class="p-2 space-y-1 min-w-0">
                    {{-- Judul --}}
                    <h3 class="font-bold whitespace-nowrap truncate leading-tight" 
                        style="color: {{ $textColor }}; font-size: clamp(10px, 2.5vw, 14px); min-height: 18px;">
                        {{ $p2Title }}
                    </h3>
                    
                    {{-- Harga --}}
                    <div class="text-xs md:text-sm font-black tracking-tight truncate" style="color: {{ $priceColor }};">
                        Rp {{ number_format($p2Price, 0, ',', '.') }}
                    </div>

                    {{-- Deskripsi --}}
                    <p class="text-[9px] md:text-xs text-slate-400 line-clamp-1 leading-none truncate">
                        {{ strip_tags($p2Desc) }}
                    </p>
                </div>
            </div>

            <div class="p-2 pt-0">
                {{-- Tombol Keranjang Livewire Produk 2 --}}
                <button type="button" 
                    wire:click="addToCart('{{ $p2Id }}', '{{ addslashes($p2Title) }}', {{ $p2Price }}, 'product')"
                    x-on:click="$dispatch('cartUpdated')"
                    class="w-full block text-center font-bold text-[10px] md:text-xs py-1.5 px-2 rounded-md transition duration-150 transform active:scale-95 shadow-sm truncate cursor-pointer"
                    style="background-color: {{ $btnBgColor }}; color: {{ $btnTextColor }};">
                    {{ $btnText }}
                </button>
            </div>
        </div>

    </div>
</div>