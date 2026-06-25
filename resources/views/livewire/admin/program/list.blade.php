<div>
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-emerald-100 text-emerald-800 rounded-xl font-medium">
            {{ session('message') }}
        </div>
    @endif

    {{-- HEADER --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Manajemen Program</h1>
            <p class="text-sm text-slate-500">Kelola daftar program pelatihan dan akses produknya.</p>
        </div>

        <button wire:click="create" class="flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tambah Program
        </button>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-4 mb-6 flex flex-col sm:flex-row gap-4 justify-between">

            <input
                wire:model.live="search"
                type="text"
                class="w-full sm:w-80 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none"
                placeholder="Cari produk..."
            >

            <select wire:model.live="filterStatus"
                class="px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">

                <option value="">Semua Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>

            </select>
        </div>

    {{-- GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

        @forelse($programs as $program)
            <div wire:key="program-{{ $program->id }}"
                class="group bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                
                <a href="{{ route('program.show', $program->id) }}" class="block flex-1 cursor-pointer">
                    
                    {{-- IMAGE --}}
                    <div class="h-44 bg-slate-100 overflow-hidden relative">
                        @if($program->image)
                            <img src="{{ asset($program->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <img src="https://ui-avatars.com/api/?title={{ urlencode($program->title) }}&background=f1f5f9&color=64748b" class="w-full h-full object-cover">
                        @endif

                        @if($program->digital_assets)
                            <span class="absolute bottom-2 left-2 px-2 py-0.5 text-[10px] font-bold bg-indigo-600 text-white rounded-md shadow-sm uppercase tracking-wider">
                                Digital Asset
                            </span>
                        @endif
                    </div>

                    {{-- CONTENT --}}
                    <div class="p-4 space-y-2">

                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-bold text-slate-800 line-clamp-2 group-hover:text-indigo-600 transition text-base leading-snug">
                                {{ $program->title }}
                            </h3>
                        </div>      

                        <div class="flex items-center justify-between pt-1">
                            <div>
                                <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wider">Harga</p>
                                <p class="font-extrabold text-slate-900 text-lg">
                                    Rp {{ number_format($program->price, 0, ',', '.') }}
                                </p>
                            </div>

                            @if($program->status === 'active')
                                <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    Active
                                </span>
                            @else
                                <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-50 text-slate-500 border border-slate-200">
                                    Inactive
                                </span>
                            @endif
                        </div>

                    </div>
                </a>

                {{-- ACTION (Tombol aksi diletakkan di luar tag <a> agar action Livewire tidak bentrok) --}}
                <div class="px-4 pb-4 pt-2 flex items-center justify-between gap-2 bg-slate-50/50 border-t border-slate-100">

                    <button wire:click="edit({{ $program->id }})"
                        class="flex-1 py-2 text-xs font-bold rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200/40 transition text-center">
                        Edit
                    </button>
                    <a href="{{ route('program.show', $program->id) }}" 
                        class="cursor-pointer text-center flex-1 py-2 text-xs font-bold rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200/40 transition">
                            Detail
                    </a>
                    <button wire:click="delete({{ $program->id }})"
                        onclick="confirm('Hapus program ini?') || event.stopImmediatePropagation()"
                        class="flex-1 py-2 text-xs font-bold rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200/40 transition text-center">
                        Hapus
                    </button>

                </div>

            </div>
        @empty
            <div class="col-span-full text-center py-12 text-slate-400 bg-white border border-dashed rounded-2xl">
                Tidak ada program ditemukan
            </div>
        @endforelse

    {{-- MODAL --}}
    @if($openModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 overflow-y-auto">
            <div class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl my-8 overflow-hidden flex flex-col max-h-[90vh]">
                <div class="px-6 py-4 border-b flex justify-between items-center bg-slate-50 sticky top-0 z-10">
                    <h2 class="font-bold text-slate-800 text-lg">{{ $editMode ? 'Edit Program' : 'Tambah Program Baru' }}</h2>
                    <button wire:click="$set('openModal', false)" class="cursor-pointer text-slate-400 hover:text-slate-600 text-xl">✕</button>
                </div>

                <form wire:submit.prevent="save" class="p-6 space-y-6 overflow-y-auto flex-1 grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- KIRI --}}
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Program</label>
                            <input type="text" wire:model.live="title" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-indigo-500 outline-none">
                            @error('title') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                         <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Slug (URL)</label>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-slate-400 bg-slate-100 px-3 py-2.5 rounded-xl border border-slate-200">domain.com/</span>
                                <input type="text" wire:model="slug" placeholder="produk-anda" class="flex-1 px-4 py-2.5 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-indigo-500 outline-none" disabled>
                            </div>
                            @error('slug') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Harga</label>
                            <input type="number" wire:model="price" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-indigo-500 outline-none">
                            @error('price') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            {{-- Tgl Mulai --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Tgl Mulai</label>
                                <input type="date" wire:model="start_date" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-slate-50">
                                @error('start_date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            {{-- Tgl Selesai --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Tgl Selesai</label>
                                <input type="date" wire:model="end_date" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-slate-50">
                                @error('end_date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Status</label>
                                <select wire:model="status" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-indigo-500 outline-none">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Non-Aktif</option>
                                </select>
                            </div>  
                    </div>

                    <div class="space-y-4 border-t md:border-t-0 md:border-l border-slate-100 md:pl-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi</label>
                            <textarea wire:model="description" rows="3" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
                            @error('description') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Sumber Gambar</label>
                            <div class="grid grid-cols-3 gap-2 bg-slate-100 p-1 rounded-xl">
                                <button type="button" wire:click="$set('image_source', 'upload')" class="py-1.5 text-xs font-medium rounded-lg transition {{ $image_source === 'upload' ? 'bg-white shadow text-slate-900' : 'text-slate-500' }}">Upload Baru</button>
                                <button type="button" wire:click="$set('image_source', 'media')" class="py-1.5 text-xs font-medium rounded-lg transition {{ $image_source === 'media' ? 'bg-white shadow text-slate-900' : 'text-slate-500' }}">Media Library</button>
                                <button type="button" wire:click="$set('image_source', 'url')" class="py-1.5 text-xs font-medium rounded-lg transition {{ $image_source === 'url' ? 'bg-white shadow text-slate-900' : 'text-slate-500' }}">URL Gambar</button>
                            </div>
                        </div>

                        {{-- Opsi 1: Upload File --}}
                        @if($image_source === 'upload')
                            <div class="space-y-2">
                                <x-image-cropper
                                                    wire-model="image"
                                                    :aspect-ratio="1"
                                                />
                                @error('image') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                @if ($image)
                                    <div class="mt-2 w-32 h-32 rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                        <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{-- Opsi 2: Menggunakan Link URL --}}
                        @if($image_source === 'url')
                            <div class="space-y-2">
                                <input type="text" wire:model.live="image_url" placeholder="https://example.com/image.jpg" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                                @error('image_url') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                @if($image_url)
                                    <div class="mt-2 w-32 h-32 rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                        <img src="{{ $image_url }}" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/150?text=Format+Salah'">
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{-- Opsi 3: Memilih dari Media Library dengan Custom Pagination --}}
                        @if($image_source === 'media')
                            <div class="space-y-3">
                                <input type="text" wire:model.live="searchMedia" placeholder="Cari di media library..." class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-slate-50 outline-none focus:ring-2 focus:ring-indigo-500">
                                
                                {{-- Grid List Media --}}
                                <div class="grid grid-cols-4 gap-2 max-h-[180px] overflow-y-auto p-1 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                                    @forelse($mediaItems as $item)
                                        <div wire:click="selectMedia('{{ $item->file }}')" 
                                             class="relative aspect-square rounded-lg overflow-hidden cursor-pointer border-2 transition group {{ $media_id === $item->file ? 'border-indigo-600 ring-2 ring-indigo-600/20' : 'border-transparent hover:border-slate-300' }}">
                                            <img src="{{ asset($item->file) }}" class="w-full h-full object-cover">
                                            
                                            @if($media_id === $item->file)
                                                <div class="absolute inset-0 bg-indigo-600/10 flex items-center justify-center">
                                                    <span class="bg-indigo-600 text-white rounded-full p-0.5 shadow">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="col-span-4 text-center py-6 text-xs text-slate-400">Tidak ada media.</div>
                                    @endforelse
                                </div>

                                {{-- PAGINASI KHUSUS MEDIA --}}
                                <div class="mt-2 text-xs opacity-80 sm-pagination">
                                    {{ $mediaItems->links(data: ['pageName' => 'mediaPage']) }}
                                </div>
                            </div>
                        @endif

                        {{-- FALLBACK PREVIEW GAMBAR LAMA SAAT EDIT --}}
                        @if($editMode && $existingImage && !$image && !$image_url && ($image_source !== 'media' || !$media_id))
                            <div class="pt-2 border-t border-slate-100">
                                <span class="text-xs font-semibold text-slate-500 block mb-1">Gambar Saat Ini:</span>
                                <div class="w-24 h-24 rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                    <img src="{{ asset($existingImage) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-span-full border-t pt-4 flex justify-end gap-3">
                        <button type="button" wire:click="$set('openModal', false)" class="px-5 py-2.5 rounded-xl bg-slate-100 font-semibold text-sm">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold text-sm">Simpan Program</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>