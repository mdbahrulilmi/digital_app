<div class="p-6">
    
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-6">

        <div>

            <h1 class="text-3xl font-black text-slate-900">
                Materi Program
            </h1>

            <p class="mt-1 text-slate-500">
                Jelajahi seluruh materi pembelajaran program.
            </p>

        </div>
    </div>
    
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm mb-6">

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
                    placeholder="Cari materi..."

                    class="w-full rounded-xl border border-slate-200
                    pl-11 pr-4 py-3
                    focus:ring-2
                    focus:ring-indigo-500
                    focus:border-indigo-500">

            </div>
            
            <select
                wire:model.live="filter"
                class="rounded-xl border border-slate-200 px-4 py-3 lg:w-60">

                <option value="">Semua Materi</option>
                <option value="video">🎥 Video</option>
                <option value="file">📄 PDF</option>
                <option value="audio">🎵 Audio</option>
                <option value="image">🖼 Gambar</option>
                <option value="link">🔗 Link</option>

            </select>

        </div>

    </div>
    
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        
        <div
            class="hidden md:grid grid-cols-12 gap-4
            bg-slate-50 border-b border-slate-200
            px-5 py-3">

            <div class="col-span-8 text-xs font-bold uppercase tracking-wider text-slate-500">
                Nama Materi
            </div>

            <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-slate-500">
                Tipe
            </div>

            <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-right text-slate-500">
                Aksi
            </div>

        </div>

        @forelse($products as $product)

            @php

                $asset=json_decode($product->digital_assets,true);

                switch($product->type){

                    case 'video':
                        $icon='🎥';
                        $badge='bg-red-100 text-red-700';
                        break;

                    case 'audio':
                        $icon='🎵';
                        $badge='bg-purple-100 text-purple-700';
                        break;

                    case 'image':
                        $icon='🖼';
                        $badge='bg-green-100 text-green-700';
                        break;

                    case 'file':
                        $icon='📄';
                        $badge='bg-orange-100 text-orange-700';
                        break;

                    default:
                        $icon='🔗';
                        $badge='bg-blue-100 text-blue-700';

                }

            @endphp
            <div
            class="group border-b border-slate-100 last:border-b-0
                   hover:bg-indigo-50/60 transition-all duration-200">
            
            <div class="hidden md:grid grid-cols-12 gap-4 items-center px-5 py-3">
                
                <div class="col-span-8 flex items-center gap-3 min-w-0">

                    <div class="w-10 h-10 rounded-lg {{ $badge }} flex items-center justify-center text-lg shrink-0">
                        {{ $icon }}
                    </div>

                    <div class="truncate">

                        <h3 class="font-medium text-slate-800 truncate group-hover:text-indigo-600">
                            {{ $product->title }}
                        </h3>

                    </div>

                </div>
                
                <div class="col-span-2">

                    <span class="px-2 py-1 rounded-full text-[11px] font-semibold {{ $badge }}">
                        {{ strtoupper($product->type) }}
                    </span>

                </div>
                
                 <div class="col-span-2 flex justify-end">

                    <button
                        wire:click="openProduct({{ $product->id }})"
                        type="button"
                        class="inline-flex items-center gap-2
                        rounded-lg
                        border border-slate-200
                        bg-white
                        px-4 py-2
                        text-sm
                        font-semibold
                        text-slate-700
                        hover:bg-indigo-600
                        hover:border-indigo-600
                        hover:text-white
                        transition
                        cursor-pointer">

                        Buka

                    </button>

                </div>

            </div>
            
            <div class="md:hidden flex items-center gap-3 p-4">

                <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-lg">
                    {{ $icon }}
                </div>

                <div class="flex-1 min-w-0">

                    <h3 class="truncate font-medium text-slate-800">
                        {{ $product->title }}
                    </h3>

                </div>

                <span class="px-2 py-1 rounded-full text-[10px] font-semibold {{ $badge }}">
                    {{ strtoupper($product->type) }}
                </span>

            </div>

        </div>
                @empty

        <div class="py-24 flex flex-col items-center justify-center text-center">

            <div
                class="w-20 h-20 rounded-2xl
                bg-slate-100
                flex items-center justify-center">

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

                Materi tidak ditemukan

            </h2>

            <p class="mt-2 text-slate-500 max-w-md">

                Coba ubah kata kunci pencarian atau filter materi.

            </p>

        </div>

        @endforelse

    </div>
    
    <div
        class="mt-5 flex flex-col md:flex-row
        md:items-center
        md:justify-between
        gap-3">

        <div class="text-sm text-slate-500">

            Menampilkan

            <span class="font-bold text-slate-700">

                {{ $products->count() }}

            </span>

            materi

        </div>

    </div>

    @include('livewire.member.program.components.modals.today-modal')

</div>