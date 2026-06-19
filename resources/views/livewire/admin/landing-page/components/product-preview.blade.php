@php
    $content = $section->content ?? [];

    $fontFamily    = $content['font_family'] ?? 'font-sans';
    $alignment     = $content['alignment'] ?? 'text-left';
    $textColor     = $content['text_color'] ?? '#1e293b';
    $priceColor    = $content['price_color'] ?? '#4f46e5';
    $oldPriceColor = $content['old_price_color'] ?? '#4f46e5';
    $btnBgColor    = $content['btn_bg_color'] ?? '#4f46e5';
    $btnTextColor  = $content['btn_text_color'] ?? '#ffffff';

    $productId     = $content['product_id'] ?? $section->id;
    $productTitle  = $content['title'] ?? 'Nama Produk';
    $description   = $content['description'] ?? '';

    $imageUrl      = $content['image_url'] ?? null;

    $badge         = $content['badge'] ?? null;
    $badgeBgColor  = $content['badge_bg_color'] ?? '#f43f5e';
    $badgeTextColor= $content['badge_text_color'] ?? '#ffffff';

    $price         = $content['price'] ?? 0;
    $oldPrice      = $content['old_price'] ?? null;

    $buttonText    = $content['button_text'] ?? 'Masukkan Keranjang';
@endphp

<div class="py-8 px-6 bg-white flex justify-center">
    <div class="w-full max-w-sm bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-lg flex flex-col {{ $fontFamily }} {{ $alignment }}">

        <div class="relative w-full h-56 bg-slate-100 flex items-center justify-center overflow-hidden">

            @if($imageUrl)
                <img
                    src="{{ $imageUrl }}"
                    alt="{{ $productTitle }}"
                    class="w-full h-full object-cover"
                >
            @else
                <svg
                    class="w-16 h-16 text-slate-300"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                    />
                </svg>
            @endif

            @if($badge)
                <span
                    class="absolute top-4 left-4 font-bold text-[10px] px-3 py-1 rounded-full uppercase tracking-wider shadow-lg z-10 transition-all hover:scale-105"
                    style="
                        background-color: {{ $badgeBgColor }};
                        color: {{ $badgeTextColor }};
                    "
                >
                    {{ $badge }}
                </span>
            @endif

        </div>

        <div class="p-6 flex-1 flex flex-col space-y-2">

            <h3
                class="font-extrabold text-xl tracking-tight break-words"
                style="color: {{ $textColor }};"
            >
                {{ $productTitle }}
            </h3>
            <div
                class="flex flex-col gap-1 {{
                    $alignment === 'text-center'
                        ? 'items-center'
                        : ($alignment === 'text-right'
                            ? 'items-end'
                            : 'items-start')
                }}"
            >
                @if($oldPrice)
                    <span
                        class="text-sm font-medium line-through"
                        style="color: {{ $oldPriceColor }};"
                    >
                        Rp {{ number_format($oldPrice, 0, ',', '.') }}
                    </span>
                @endif

                <span
                    class="text-xl font-black"
                    style="color: {{ $priceColor }};"
                >
                    Rp {{ number_format($price, 0, ',', '.') }}
                </span>
            </div>

            <div class="text-sm text-slate-600 leading-relaxed flex-1 line-clamp-3">
                {{ $description }}
            </div>

            <div class="pt-4">
                <button
                    type="button"
                    wire:click="addToCart('{{ $productId }}', '{{ addslashes($productTitle) }}', {{ $price }}, 'product')"
                    x-on:click="$dispatch('cartUpdated')"
                    class="w-full block text-center font-bold text-sm py-3 px-6 rounded-xl shadow-md hover:opacity-95 transition duration-150 transform active:scale-95 cursor-pointer"
                    style="
                        background-color: {{ $btnBgColor }};
                        color: {{ $btnTextColor }};
                    "
                >
                    {{ $buttonText }}
                </button>
            </div>

        </div>
    </div>
</div>