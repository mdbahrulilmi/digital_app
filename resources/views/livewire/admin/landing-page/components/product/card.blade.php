@php
    $productId = $content['product_id'] ?? null;
    $productSlug = $content['slug'] ?? '/';

    $productTitle = $content['title'] ?? 'Nama Produk';
    $description = $content['description'] ?? 'Deskripsi produk belum tersedia.';

    $price = $content['price'] ?? 0;
    $oldPrice = $content['old_price'] ?? null;

    $imageUrl = $content['image_url'] ?? null;
    $badge = $content['badge'] ?? null;
@endphp

<div class="w-full h-full bg-white rounded-lg overflow-hidden border border-slate-200 shadow-sm flex flex-col">

    <div class="relative aspect-square bg-slate-100 overflow-hidden shrink-0">

        @if($imageUrl)
            <img
                src="{{ $imageUrl }}"
                alt="{{ $productTitle }}"
                class="w-full h-full object-cover"
            >
        @else
            <div class="w-full h-full flex items-center justify-center text-slate-300 text-sm">
                No Image
            </div>
        @endif


        @if($badge)
            <span
                class="absolute top-2 left-2 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-sm shadow">
                {{ $badge }}
            </span>
        @endif

    </div>



    <div class="p-3 flex flex-col flex-1">

        <h3 class="text-2sm font-semibold leading-snug text-slate-800 h-[40px] overflow-hidden line-clamp-2">
            {{ $productTitle }}
        </h3>

        <p class="hidden @min-[320px]:block mt-1 text-xs text-slate-500 leading-relaxed h-[40px] overflow-hidden line-clamp-2 mb-2">
            {{ $description }}
        </p>

        <div class="h-[42px] flex flex-col justify-end">

            <div class="h-[16px]">
                @if($oldPrice)
                    <div class="text-[11px] text-slate-400 line-through leading-4">
                        Rp {{ number_format($oldPrice,0,',','.') }}
                    </div>
                @endif
            </div>


            <div class="text-lg font-bold text-indigo-500 leading-6">
                Rp {{ number_format($price,0,',','.') }}
            </div>

        </div>



        <div class="mt-auto pt-3 grid grid-cols-1 @min-[320px]:grid-cols-2 gap-2">

            <a
                href="{{ route('public.product.show', $productSlug) }}"
                class="w-full py-2 rounded-lg text-xs font-bold border border-indigo-500 text-indigo-500 hover:bg-indigo-50 transition text-center"
            >
                Detail
            </a>


            <button
                type="button"
                wire:click="addToCart('{{ $productId }}', '{{ addslashes($productTitle) }}', {{ $price }}, 'product')"
                class="w-full py-2 rounded-lg text-xs font-bold bg-indigo-500 text-white hover:bg-indigo-600 transition cursor-pointer"
            >
                Keranjang
            </button>


        </div>


    </div>

</div>