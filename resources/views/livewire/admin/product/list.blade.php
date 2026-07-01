    <div>
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-emerald-100 text-emerald-800 rounded-xl font-medium">
                {{ session('message') }}
            </div>
        @endif

        {{-- HEADER --}}
        {{-- ================= HEADER ================= --}}
        <div class="mb-8">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <div>
                    
                    <h1 class="mt-2 text-3xl font-black text-slate-900">
                        Manajemen Produk
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Kelola seluruh produk digital, video, PDF, audio dan gambar.
                    </p>

                </div>

                <button
                    wire:click="create"
                    class="cursor-pointer inline-flex items-center justify-center gap-2
                    rounded-xl bg-indigo-600 px-6 py-3
                    font-bold text-white
                    hover:bg-indigo-700 transition">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v16m8-8H4"/>

                    </svg>

                    Tambah Produk

                </button>

            </div>

        </div>

            {{-- ================= TOOLBAR ================= --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm mb-6">

                <div class="flex flex-col xl:flex-row gap-4">

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
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 105.5 5.5a7.5 7.5 0 0011.15 11.15z"/>

                        </svg>

                        <input
                            wire:model.live.debounce.400ms="search"
                            type="text"
                            placeholder="Cari nama produk..."

                            class="w-full rounded-xl border border-slate-200
                            bg-slate-50
                            py-3 pl-11 pr-4
                            focus:ring-2 focus:ring-indigo-500">

                    </div>

                    {{-- Status --}}
                    <select
                        wire:model.live="filterStatus"
                        class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 lg:w-52">

                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Inactive</option>

                    </select>

                    {{-- Tipe --}}
                    <select
                        wire:model.live="filterType"
                        class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 lg:w-52">

                        <option value="">Semua Tipe</option>

                        <option value="video">🎥 Video</option>
                        <option value="audio">🎵 Audio</option>
                        <option value="image">🖼 Image</option>
                        <option value="file">📄 PDF/File</option>
                        <option value="link">🔗 Link</option>

                    </select>

                </div>

            </div>

        {{-- GRID --}}
        {{-- ================= PRODUCT TABLE ================= --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Header Desktop --}}
            <div
                class="hidden lg:grid grid-cols-12 gap-4
                px-6 py-4
                bg-slate-50
                border-b
                border-slate-200">

                <div class="col-span-5 text-xs font-bold uppercase tracking-wider text-slate-500">
                    Produk
                </div>

                <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-slate-500">
                    Harga
                </div>

                <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-slate-500">
                    Status
                </div>

                <div class="col-span-1 text-xs font-bold uppercase tracking-wider text-slate-500">
                    Asset
                </div>

                <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-right text-slate-500">
                    Aksi
                </div>

            </div>

            @forelse($products as $product)

                @php

                    $asset = json_decode($product->digital_assets,true);

                    $type = $asset['type'] ?? $product->type;

                    switch($type){

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

                {{-- ================= DESKTOP ================= --}}
                <div
                    wire:key="product-{{ $product->id }}"
                    class="hidden lg:grid grid-cols-12 gap-4 items-center
                    px-6 py-4
                    border-b border-slate-100
                    hover:bg-indigo-50/50 transition">

                    {{-- Produk --}}
                    <div class="col-span-5 flex items-center gap-4 min-w-0">

                        <div class="w-14 h-14 rounded-xl overflow-hidden bg-slate-100 shrink-0">

                            @if($product->image)

                                <img
                                    src="{{ asset($product->image) }}"
                                    class="w-full h-full object-cover">

                            @else

                                <img
                                    src="https://ui-avatars.com/api/?name={{ urlencode($product->title) }}"
                                    class="w-full h-full object-cover">

                            @endif

                        </div>

                        <div class="min-w-0">

                            <h3 class="font-bold truncate">

                                {{ $product->title }}

                            </h3>

                            <p class="text-xs text-slate-500 truncate">

                                {{ $product->slug }}

                            </p>

                        </div>

                    </div>

                    {{-- Harga --}}
                    <div class="col-span-2">

                        <div class="font-bold text-slate-800">

                            Rp {{ number_format($product->price,0,',','.') }}

                        </div>

                    </div>

                    {{-- Status --}}
                    <div class="col-span-2">

                        @if($product->status=='active')

                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">

                                Active

                            </span>

                        @else

                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">

                                Inactive

                            </span>

                        @endif

                    </div>

                    {{-- Asset --}}
                    <div class="col-span-1">

                        <span class="px-2 py-1 rounded-lg text-xs font-bold {{ $badge }}">

                            {{ $icon }}

                        </span>

                    </div>

                    {{-- Action --}}
                    <div class="col-span-2">

                        <div class="flex justify-end gap-2">

                            <button
                                wire:click="edit({{ $product->id }})"
                                class="w-10 h-10 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700">

                                ✏️

                            </button>

                            <a
                                href="{{ route('product.show',$product->id) }}"
                                class="w-10 h-10 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 flex items-center justify-center">

                                👁

                            </a>

                            <button
                                wire:click="delete({{ $product->id }})"
                                onclick="confirm('Hapus produk ini?') || event.stopImmediatePropagation()"
                                class="w-10 h-10 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700">

                                🗑

                            </button>

                        </div>

                    </div>

                </div>

                {{-- ================= MOBILE ================= --}}
                <div
                    class="lg:hidden p-4 border-b border-slate-100">

                    <div class="flex gap-4">

                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-100 shrink-0">

                            @if($product->image)

                                <img
                                    src="{{ asset($product->image) }}"
                                    class="w-full h-full object-cover">

                            @endif

                        </div>

                        <div class="flex-1 min-w-0">

                            <h3 class="font-bold truncate">

                                {{ $product->title }}

                            </h3>

                            <p class="text-xs text-slate-500 truncate">

                                {{ $product->slug }}

                            </p>

                            <div class="flex items-center gap-2 mt-3">

                                <span class="px-2 py-1 rounded-full text-[10px] {{ $badge }}">

                                    {{ strtoupper($type) }}

                                </span>

                                <span class="text-xs text-slate-500">

                                    Rp {{ number_format($product->price,0,',','.') }}

                                </span>

                            </div>

                            <div class="flex gap-2 mt-4">

                                <button
                                    wire:click="edit({{ $product->id }})"
                                    class="flex-1 py-2 rounded-lg bg-amber-50 text-amber-700 text-xs font-bold">

                                    Edit

                                </button>

                                <a
                                    href="{{ route('product.show',$product->id) }}"
                                    class="flex-1 py-2 rounded-lg bg-blue-50 text-blue-700 text-xs font-bold text-center">

                                    Detail

                                </a>

                                <button
                                    wire:click="delete({{ $product->id }})"
                                    onclick="confirm('Hapus produk ini?') || event.stopImmediatePropagation()"
                                    class="flex-1 py-2 rounded-lg bg-rose-50 text-rose-700 text-xs font-bold">

                                    Hapus

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="py-20 text-center text-slate-400">

                    Tidak ada produk ditemukan.

                </div>

            @endforelse

        </div>

        {{-- PAGINATION --}}
        {{-- ================= FOOTER ================= --}}
        <div class="mt-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div class="text-sm text-slate-500">

                Menampilkan
                <span class="font-bold text-slate-800">
                    {{ $products->firstItem() ?? 0 }}
                </span>
                -
                <span class="font-bold text-slate-800">
                    {{ $products->lastItem() ?? 0 }}
                </span>

                dari

                <span class="font-bold text-indigo-600">
                    {{ $products->total() }}
                </span>

                produk

            </div>

            <div>

                {{ $products->links() }}

            </div>

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