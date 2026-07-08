<div class="p-2">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-6">

        <div>
            <h1 class="text-3xl font-black text-slate-900">
                Produk Eksklusif Anda
            </h1>

            <p class="mt-1 text-slate-500">
                Jelajahi seluruh produk yang sudah Anda miliki.
            </p>
        </div>

    </div>

    {{-- Toolbar --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm mb-6">

        <div class="flex flex-col lg:flex-row gap-3">

            {{-- Search --}}
            <div class="relative flex-1">

                <svg
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 21l-5-5m2-5a7 7 0 11-14 0a7 7 0 0114 0"/>

                </svg>

                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Cari produk..."
                    class="w-full rounded-xl border border-slate-200 pl-11 pr-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

            </div>

            {{-- Filter --}}
            <select
                wire:model.live="filter"
                class="rounded-xl border border-slate-200 px-4 py-3 lg:w-60">

                <option value="">Semua Produk</option>
                <option value="video">🎥 Video</option>
                <option value="file">📄 PDF</option>
                <option value="audio">🎵 Audio</option>
                <option value="image">🖼 Gambar</option>
                <option value="link">🔗 Link</option>

            </select>

        </div>

    </div>

    {{-- Product Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        @forelse($orderItems as $item)

            <div class="bg-white border border-slate-200 rounded-3xl p-5 shadow-sm hover:shadow-xl transition duration-300">

                {{-- Image --}}
                <div class="w-full aspect-video rounded-2xl overflow-hidden bg-slate-100 mb-5">

                    <img
                        src="{{ asset($item->product->image) }}"
                        alt="{{ $item->product->title }}"
                        class="w-full h-full object-cover">

                </div>

                {{-- Category Badge --}}
                @if($item->product->category)
                    <span class="inline-flex mb-3 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                        {{ $item->product->category->name }}
                    </span>
                @endif

                {{-- Title --}}
                <h3 class="font-bold text-slate-900 text-lg line-clamp-1">
                    {{ $item->product->title }}
                </h3>

                {{-- Description --}}
                <p class="mt-2 text-sm text-slate-500 line-clamp-2">
                    {{ $item->product->description ?? 'Deskripsi belum tersedia.' }}
                </p>

                {{-- Button --}}
                <a
                    href="{{ route('member.product.show',$item->product->slug) }}"
                    class="mt-6 block w-full rounded-xl bg-slate-900 py-3 text-center text-sm font-semibold text-white hover:bg-indigo-600 transition">

                    Lihat Detail

                </a>

            </div>

        @empty

            <div class="col-span-full py-24 flex flex-col items-center justify-center">

                <div class="w-20 h-20 rounded-2xl bg-slate-100 flex items-center justify-center">

                    <svg
                        class="w-10 h-10 text-slate-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6M7 3h7l5 5v13H7z"/>

                    </svg>

                </div>

                <h2 class="mt-5 text-xl font-bold text-slate-700">
                    Produk tidak ditemukan
                </h2>

                <p class="mt-2 text-slate-500">
                    Coba ubah kata kunci pencarian atau filter produk.
                </p>

            </div>

        @endforelse

    </div>

    {{-- Footer --}}
    <div class="mt-6 flex items-center justify-between">

        <p class="text-sm text-slate-500">

            Menampilkan

            <span class="font-bold text-slate-700">
                {{ $orderItems->count() }}
            </span>

            produk

        </p>

    </div>

</div>