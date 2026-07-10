<div class="p-2">

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

    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm mb-6">

        <div class="flex flex-col lg:flex-row gap-3">

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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">

        @forelse($orderItems as $item)

        <div class="flex h-full flex-col rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition duration-300 hover:shadow-xl">

            <div class="flex-1">

                <div class="relative mb-5 aspect-video w-full overflow-hidden rounded-xl bg-slate-100">

                    <img
                        src="{{ asset($item->product->image) }}"
                        alt="{{ $item->product->title }}"
                        class="h-full w-full object-cover">

                    @if($item->product->type)
                        @php
                            $type = strtolower($item->product->type);

                            $badge = match ($type) {
                                'video' => 'bg-red-100 text-red-700',
                                'audio' => 'bg-purple-100 text-purple-700',
                                'image' => 'bg-green-100 text-green-700',
                                'file'  => 'bg-orange-100 text-orange-700',
                                'link'  => 'bg-blue-100 text-blue-700',
                                default => 'bg-slate-100 text-slate-700',
                            };
                        @endphp

                        <span class="absolute top-3 right-3 rounded-full px-3 py-1 text-xs font-semibold {{ $badge }}">
                            {{ ucfirst($type) }}
                        </span>
                    @endif

                </div>

                <h3
                    class="line-clamp-2 min-h-[40px] font-bold text-slate-900
                    {{ strlen($item->product->title) > 30 ? 'text-base' : 'text-lg' }}">
                    {{ $item->product->title }}
                </h3>

                <p class="line-clamp-2 min-h-[40px] text-sm text-slate-500">
                    {{ $item->product->description ?? 'Deskripsi belum tersedia.' }}
                </p>

            </div>

            <a
                href="{{ route('member.product.show', $item->product->slug) }}"
                class="mt-6 block w-full rounded-xl bg-slate-900 py-3 text-center text-sm font-semibold text-white transition hover:bg-indigo-600">

                Lihat

            </a>

        </div>

    @empty

            <div class="col-span-full py-24 flex flex-col items-center justify-center">

                <div class="w-20 h-20 rounded-xl bg-slate-100 flex items-center justify-center">

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