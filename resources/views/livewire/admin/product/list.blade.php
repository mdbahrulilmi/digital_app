    <div>
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-emerald-100 text-emerald-800 rounded-xl font-medium">
                {{ session('message') }}
            </div>
        @endif

        {{-- HEADER --}}
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Manajemen Produk</h1>
                <p class="text-sm text-slate-500">Kelola produk dalam tampilan grid modern.</p>
            </div>

            <button
                wire:click="create"
                class="cursor-pointer flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md transition-all">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>

                Tambah Produk
            </button>
        </div>

        {{-- FILTER --}}
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

        @forelse($products as $product)
            <div wire:key="product-{{ $product->id }}"
                class="group bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                
                <a href="{{ route('product.show', $product->id) }}" class="block flex-1 cursor-pointer">
                    
                    {{-- IMAGE --}}
                    <div class="h-44 bg-slate-100 overflow-hidden relative">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <img src="https://ui-avatars.com/api/?title={{ urlencode($product->title) }}&background=f1f5f9&color=64748b" class="w-full h-full object-cover">
                        @endif

                        @if($product->digital_assets)
                            <span class="absolute bottom-2 left-2 px-2 py-0.5 text-[10px] font-bold bg-indigo-600 text-white rounded-md shadow-sm uppercase tracking-wider">
                                Digital Asset
                            </span>
                        @endif
                    </div>

                    {{-- CONTENT --}}
                    <div class="p-4 space-y-2">

                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-bold text-slate-800 line-clamp-2 group-hover:text-indigo-600 transition text-base leading-snug">
                                {{ $product->title }}
                            </h3>
                        </div>      

                        <div class="flex items-center justify-between pt-1">
                            <div>
                                <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wider">Harga</p>
                                <p class="font-extrabold text-slate-900 text-lg">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>

                            @if($product->status === 'active')
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

                    <button wire:click="edit({{ $product->id }})"
                        class="flex-1 py-2 text-xs font-bold rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200/40 transition text-center">
                        Edit
                    </button>
                    <a href="{{ route('product.show', $product->id) }}" 
                        class="cursor-pointer text-center flex-1 py-2 text-xs font-bold rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200/40 transition">
                            Detail
                    </a>
                    <button wire:click="delete({{ $product->id }})"
                        onclick="confirm('Hapus produk ini?') || event.stopImmediatePropagation()"
                        class="flex-1 py-2 text-xs font-bold rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200/40 transition text-center">
                        Hapus
                    </button>

                </div>

            </div>
        @empty
            <div class="col-span-full text-center py-12 text-slate-400 bg-white border border-dashed rounded-2xl">
                Tidak ada produk ditemukan
            </div>
        @endforelse

    </div>

        {{-- PAGINATION --}}
        <div class="mt-6">
            {{ $products->links() }}
        </div>

    <div>
        @if($openModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
                <div class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl my-8 overflow-hidden flex flex-col max-h-[95vh]">
                    
                    <div class="px-6 py-4 border-b flex justify-between items-center bg-slate-50 sticky top-0 z-10">
                        <h2 class="font-bold text-slate-800 text-lg">{{ $editMode ? 'Edit Produk' : 'Tambah Produk Baru' }}</h2>
                        <button wire:click="$set('openModal', false)" class="text-slate-400 hover:text-slate-600 text-xl">✕</button>
                    </div>

                    <form wire:submit.prevent="save" class="p-6 space-y-6 flex-1 grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Produk</label>
                                <input type="text" wire:model.live="title" placeholder="Masukkan nama produk" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-indigo-500 outline-none">
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
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Harga (IDR)</label>
                                <input type="number" wire:model="price" placeholder="0" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-indigo-500 outline-none">
                                @error('price') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi</label>
                                <textarea wire:model="description" rows="3" placeholder="Deskripsi lengkap produk..." class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
                                 @error('description') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
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
                            <div class="p-4 bg-indigo-50/50 rounded-2xl border border-indigo-100 space-y-3">
                                <label class="block text-sm font-semibold text-indigo-950">Digital Asset</label>
                                
                                <div class="flex gap-4 text-sm">
                                    <label><input type="radio" wire:model.live="asset_source" value="upload"> Upload File</label>
                                    <label><input type="radio" wire:model.live="asset_source" value="link"> Masukkan Link</label>
                                </div>
                                
                                <select wire:model="asset_type" class="w-full px-3 py-2 border rounded-xl text-sm">
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="file">Dokumen (Zip/PDF)</option>
                                    <option value="image">Gambar</option>
                                    <option value="audio">Audio</option>
                                    <option value="video">Video</option>
                                </select>
                                @error('asset_type') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                @if($asset_source === 'upload')
                                    <input type="file" wire:model="digital_asset_file" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200">
                                @error('digital_asset_file') <span class="text-xs text-red-500 block mt-1">{{ $message }}</span> @enderror
                                
                                @if ($digital_assets)
                                    @php
                                        $asset = is_string($digital_assets) ? json_decode($digital_assets) : (object) $digital_assets;
                                    @endphp
                                    
                                    <div class="mt-2 flex items-center gap-2 text-xs text-slate-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span class="truncate">File Saat Ini: {{ $asset->name ?? 'File tidak bernama' }}</span>
                                    </div>
                                    @endif
                                @else
                                    <input type="text" wire:model="digital_asset_url" placeholder="https://..." class="w-full px-4 py-2 border rounded-xl">
                                @endif
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
                                        {{ $mediaItems->links(data: ['pagetitle' => 'mediaPage']) }}
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

                        {{-- FOOTER MODAL --}}
                        <div class="col-span-full border-t pt-4 flex justify-end gap-3 bg-white sticky bottom-0 pb-4">
                            <button type="button" wire:click="$set('openModal', false)" 
                                    class="cursor-pointer px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm transition">
                                Batal
                            </button>
                            
                            <button type="submit" 
                                    {{-- Tombol akan disable jika file sedang diupload --}}
                                    wire:loading.attr="disabled"
                                    wire:target="digital_asset_file, image"
                                    class="cursor-pointer px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md transition disabled:opacity-50 disabled:cursor-not-allowed">
                                
                                {{-- Menampilkan teks status saat proses berlangsung --}}
                                <span wire:loading.remove wire:target="digital_asset_file, image">
                                    {{ $editMode ? 'Simpan Perubahan' : 'Tambah Produk' }}
                                </span>
                                <span wire:loading wire:target="digital_asset_file, image">
                                    Mengunggah...
                                </span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        @endif
    </div>