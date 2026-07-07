@php
    $productId = $content['id'] ?? null;
    $productSlug = $content['slug'] ?? '/';

    $productTitle = $content['title'] ?? 'Nama Produk';
    $productDescription = $content['description'] ?? 'Deskripsi produk belum tersedia.';

    $price = $content['price'] ?? 0;
    $oldPrice = $content['old_price'] ?? null;

    $imageUrl = $content['image_url'] ?? null;
    $productBadge = $content['badge'] ?? null;
@endphp


<div class="w-full bg-white rounded-xl border border-slate-200 p-3 flex gap-3 shadow-sm">

    {{-- IMAGE --}}
    <div class="relative w-24 h-24 shrink-0 rounded-lg overflow-hidden bg-slate-100">

        @if($imageUrl)
            <img
                src="{{ $imageUrl }}"
                alt="{{ $productTitle }}"
                class="w-full h-full object-cover"
            >
        @else
            <div class="w-full h-full flex items-center justify-center text-xs text-slate-400">
                No Image
            </div>
        @endif


        @if($productBadge)
            <span
                class="absolute top-1 left-1 bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded">
                {{ $productBadge }}
            </span>
        @endif

    </div>



    {{-- CONTENT --}}
    <div class="flex-1 min-w-0 flex flex-col">

        {{-- TITLE --}}
        <h3 class="text-sm font-semibold text-slate-800 leading-snug line-clamp-2">
            {{ $productTitle }}
        </h3>


        {{-- DESCRIPTION --}}
        <p class="mt-1 text-[11px] text-slate-500 leading-relaxed line-clamp-2">
            {{ $productDescription }}
        </p>



        {{-- PRICE --}}
        <div class="mt-auto pt-2">

            @if($oldPrice)
                <span class="text-[10px] text-slate-400 line-through block">
                    Rp {{ number_format($oldPrice,0,',','.') }}
                </span>
            @endif


            <div class="text-base font-bold text-indigo-500">
                Rp {{ number_format($price,0,',','.') }}
            </div>

        </div>

    </div>



    {{-- ACTION --}}
    <div class="flex flex-col justify-end items-end gap-2">

        <a
            href="{{ route('public.product.show', $productSlug) }}"
            class="w-full py-2 px-4 rounded-lg text-xs font-bold border border-indigo-500 text-indigo-500 hover:bg-indigo-50 transition text-center"
        >
            Detail
        </a>


        <button
            type="button"
            wire:click="addToCart('{{ $productId }}', '{{ addslashes($productTitle) }}', {{ $price }}, 'product')"
            class="w-full py-2 px-4 rounded-lg text-xs font-bold bg-indigo-500 text-white hover:bg-indigo-600 transition cursor-pointer"
        >
            Keranjang
        </button>

    </div>


</div>