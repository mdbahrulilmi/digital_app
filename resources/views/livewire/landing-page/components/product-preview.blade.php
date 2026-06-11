@php
    $fontFamily   = $section->content['font_family'] ?? 'font-sans';
    $alignment   = $section->content['alignment'] ?? 'text-left';
    $textColor   = $section->content['text_color'] ?? '#1e293b';
    $priceColor  = $section->content['price_color'] ?? '#4f46e5';
    $oldPriceColor= $section->content['old_price_color'] ?? '#4f46e5';
    $btnBgColor  = $section->content['btn_bg_color'] ?? '#4f46e5';
    $btnTextColor= $section->content['btn_text_color'] ?? '#ffffff';

    $price = $section->content['price'] ?? 0;
    $productName = $section->content['name'] ?? 'Nama Produk';
    $productId = $section->content['product_id'] ?? $section->id;
@endphp

<div class="py-8 px-6 bg-white flex justify-center">
    <div class="w-full max-w-sm bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-lg flex flex-col {{ $fontFamily }} {{ $alignment }}">
        
        <div class="relative w-full h-56 bg-slate-100 flex items-center justify-center overflow-hidden">
            @if(!empty($section->content['image_url']))
                <img src="{{ $section->content['image_url'] }}" alt="{{ $productName }}" class="w-full h-full object-cover">
            @else
                <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 002-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            @endif

            @if(!empty($section->content['badge']))
                <span class="absolute top-4 left-4 bg-rose-500 text-white font-bold text-xs px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                    {{ $section->content['badge'] }}
                </span>
            @endif
        </div>

        <div class="p-6 flex-1 flex flex-col space-y-2">
            <h3 class="font-extrabold text-xl tracking-tight" style="color: {{ $textColor }};">
                {{ $productName }}
            </h3>
            
            <div class="flex flex-col gap-1 {{ $alignment == 'text-center' ? 'items-center' : ($alignment == 'text-right' ? 'items-end' : 'items-start') }}">
                @if(!empty($section->content['old_price']))
                    <span class="text-sm font-medium line-through" style="color: {{ $oldPriceColor }};">
                        Rp {{ number_format($section->content['old_price'] ?? 0, 0, ',', '.') }}
                    </span>
                    <span class="text-xl font-black" style="color: {{ $priceColor }};">
                        Rp {{ number_format($section->content['price'], 0, ',', '.') }}
                    </span>
                @else
                    <span class="text-xl font-black" style="color: {{ $priceColor }};">
                        Rp {{ number_format($section->content['price'] ?? 0, 0, ',', '.') }}
                    </span>
                @endif
            </div>
            
            <p class="text-sm text-slate-600 leading-relaxed flex-1">
                {!! !empty($section->content['description']) ? nl2br(e($section->content['description'])) : '' !!}
            </p>

            <div class="pt-4">
                    <button type="button" 
                    wire:click="addToCart('{{ $productId }}', '{{ addslashes($productName) }}', {{ $price }})"
                    x-on:click="$dispatch('cartUpdated')"
                    class="w-full block text-center font-bold text-sm py-3 px-6 rounded-xl shadow-md hover:opacity-95 transition duration-150 transform active:scale-95 cursor-pointer"
                    style="background-color: {{ $btnBgColor }}; color: {{ $btnTextColor }};">
                    
                        {{ $section->content['button_text'] ?? 'Masukkan Keranjang' }}
                    
                    </button>
            </div>
        </div>
    </div>
</div>

