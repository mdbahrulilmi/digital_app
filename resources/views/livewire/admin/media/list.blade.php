<div>
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-emerald-100 text-emerald-800 rounded-xl font-medium">
            {{ session('message') }}
        </div>
    @endif

    {{-- HEADER --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-slate-900">Media Library</h1>
            <p class="text-sm text-slate-500">Kelola file gambar & media</p>
        </div>

        <button
            wire:click="create"
            class="flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>

            Upload Media
        </button>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-4 mb-6 flex flex-col sm:flex-row gap-4 justify-between">

        <input
            wire:model.live="search"
            type="text"
            class="w-full sm:w-80 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none"
            placeholder="Cari media..."
        >
    </div>

    {{-- GRID --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">

        @forelse($media as $item)
            <div wire:key="media-{{ $item->id }}"
                 class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition border border-slate-100">

                {{-- IMAGE --}}
                <div class="aspect-square bg-slate-100 overflow-hidden">
                    <img src="{{ asset($item->file) }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>

                {{-- INFO --}}
                <div class="p-3">
                    <p class="text-sm font-semibold text-slate-800 truncate">
                        {{ $item->title }}
                    </p>

                    <p class="text-xs text-slate-400">
                        {{ strtoupper($item->type) }} • {{ number_format($item->size / 1024, 1) }} KB
                    </p>
                </div>

                {{-- ACTION --}}
                <div class="px-3 pb-3 flex gap-2">
                    <button
                        class="flex-1 py-1.5 text-xs rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100"
                        wire:click="delete({{ $item->id }})"
                        onclick="confirm('Hapus media ini?') || event.stopImmediatePropagation()">
                        Delete
                    </button>
                </div>

            </div>
         @empty
            <div class="col-span-full text-center py-12 text-slate-400 bg-white border border-dashed rounded-2xl">
                Tidak ada media ditemukan
            </div>
        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $media->links() }}
    </div>

    {{-- MODAL UPLOAD --}}
    @if($openModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">

            <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden">

                <div class="px-6 py-4 border-b flex justify-between items-center bg-slate-50">
                    <h2 class="font-bold text-slate-800">Upload Media</h2>
                    <button wire:click="$set('openModal', false)">✕</button>
                </div>

                <form wire:submit.prevent="save" class="p-6 space-y-4">

                    <input
                        wire:model="title"
                        placeholder="Nama media"
                        class="w-full px-4 py-2.5 border rounded-xl bg-slate-50">

                    <input
                        type="file"
                        wire:model.live="file"
                        class="w-full px-4 py-2.5 border rounded-xl bg-slate-50">

                    @error('file')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    <div class="flex justify-end gap-3">
                        <button type="button"
                            wire:click="$set('openModal', false)"
                            class="px-4 py-2 rounded-xl bg-slate-100">
                            Batal
                        </button>

                        <button 
                            type="submit" 
                            class="px-4 py-2 rounded-xl bg-indigo-600 text-white disabled:bg-indigo-300"
                            wire:loading.attr="disabled"
                            wire:target="file, save"
                        >
                            <span wire:loading.remove wire:target="file">Upload</span>
                            <span wire:loading wire:target="file">Menunggu File...</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>
    @endif

</div>