    <div>
        @if($openModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">

                <div class="bg-white w-full max-w-4xl max-h-[90vh] rounded-3xl shadow-2xl overflow-hidden flex flex-col">

                    {{-- HEADER --}}
                    <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                        <h3 class="text-xl font-bold text-slate-800">
                            {{ $editMode ? 'Edit Halaman' : 'Buat Halaman Baru' }}
                        </h3>

                        <button
                            type="button"
                            wire:click="$set('openModal', false)"
                            class="text-slate-400 hover:text-slate-600">
                            ✕
                        </button>
                    </div>

                    <form wire:submit.prevent="save" class="flex flex-col flex-1 overflow-hidden">

                        <div class="flex-1 overflow-y-auto p-8 space-y-6">

                            <div x-data="{ formTab:'general' }">

                                {{-- TAB BUTTON --}}
                                <div class="inline-flex p-1 bg-slate-100 rounded-xl mb-6">

                                    <button
                                        type="button"
                                        @click="formTab='general'"
                                        :class="formTab==='general'
                                            ? 'bg-white text-indigo-600 shadow-sm'
                                            : 'text-slate-500'"
                                        class="px-5 py-2 rounded-lg font-semibold text-sm">
                                        Umum
                                    </button>
                                
                                    <button
                                        type="button"
                                        @click="formTab='setup'"
                                        :class="formTab==='setup'
                                            ? 'bg-white text-indigo-600 shadow-sm'
                                            : 'text-slate-500'"
                                        class="px-5 py-2 rounded-lg font-semibold text-sm">
                                        Setup
                                    </button>

                                    <button
                                        type="button"
                                        @click="formTab='advanced'"
                                        :class="formTab==='advanced'
                                            ? 'bg-white text-indigo-600 shadow-sm'
                                            : 'text-slate-500'"
                                        class="px-5 py-2 rounded-lg font-semibold text-sm">
                                        Advanced
                                    </button>

                                </div>

                                {{-- GENERAL TAB --}}
                                <div x-show="formTab==='general'">

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                                        {{-- KOLOM KIRI --}}
                                        <div class="space-y-5">
                                            {{-- Judul Halaman --}}
                                            <div>
                                                <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Halaman</label>
                                                <input type="text" wire:model.live="title" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="Contoh: Tentang Kami">
                                                @error('title') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                                            </div>

                                            {{-- FITUR BARU: Set Sebagai Halaman Utama --}}
                                            <div class="relative">
                                                <label class="flex items-center gap-2.5 p-3 rounded-xl cursor-pointer transition-all select-none 
                                                    {{ ($homeExists && !$home) ? 'bg-slate-100 opacity-60 cursor-not-allowed' : 'bg-indigo-50/50 border border-indigo-100 hover:bg-indigo-50' }}">
                                                    
                                                    <input type="checkbox" 
                                                        wire:model.live="home" 
                                                        @if($homeExists && !$home) disabled @endif
                                                        class="w-4 h-4 rounded text-indigo-600 border-slate-300 focus:ring-indigo-500 accent-indigo-600 flex-shrink-0">
                                                    
                                                    <div class="flex flex-col">
                                                        <span class="text-xs font-bold text-slate-800">Jadikan Halaman Utama (Homepage)</span>
                                                        <span class="text-[10px] text-slate-500">
                                                            {{ ($homeExists && !$home) ? 'Halaman utama sudah diatur pada halaman lain.' : 'Jika aktif, halaman ini akan diakses lewat URL utama ( / )' }}
                                                        </span>
                                                    </div>
                                                </label>
                                            </div>
                                            
                                            {{-- Slug (URL) --}}
                                            <div>
                                                <label class="block text-sm font-semibold text-slate-700 mb-2">Slug (URL)</label>
                                                <div class="flex items-center">
                                                    <span class="px-3 py-2.5 bg-slate-100 border border-r-0 border-slate-200 rounded-l-xl text-slate-400 text-sm select-none">domain.com/</span>

                                                    <input type="text" 
                                                        wire:model="slug" 
                                                        @if($home || $program_id) disabled @endif
                                                        class="w-full px-4 py-2.5 border border-slate-200 rounded-r-xl outline-none transition-all {{ $home ? 'bg-slate-100 text-slate-400 cursor-not-allowed font-medium' : 'bg-slate-50 focus:ring-2 focus:ring-indigo-500' }}" 
                                                        placeholder="{{ $home ? '(Halaman Utama)' : 'tentang-kami' }}"
                                                        disabled>
                                                </div>
                                                @error('slug') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                                            </div>

                                            {{-- Status --}}
                                            <div>
                                                <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                                                <select wire:model="status" class="cursor-pointer w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-white">
                                                    <option value="published">Published</option>
                                                    <option value="draft">Draft</option>
                                                </select>
                                                @error('status') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        {{-- KOLOM KANAN --}}
                                        <div class="space-y-5">
                                            <div>
                                                <label class="block text-sm font-semibold text-slate-700 mb-2">Konten Halaman (Description)</label>
                                                <textarea wire:model="description" rows="4" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all resize-none" placeholder="Tulis isi halaman di sini..."></textarea>
                                                @error('description') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
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
                                                    :aspect-ratio="16 / 9"
                                                />
                                                @error('image') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                                @if($image)
                                                    <div class="w-32 h-32 overflow-hidden rounded-xl">
                                                        <img src="{{ $image->temporaryUrl() }}">
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
                                                        <img src="{{ filter_var($existingImage, FILTER_VALIDATE_URL) ? $existingImage : asset($existingImage) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>

                                </div>
                                
                                {{-- SETUP TAB --}}
                                <div x-show="formTab==='setup'">

                                    <div class="grid grid-cols-1 gap-8">
                                        {{-- KOLOM KANAN --}}
                                        <div class="space-y-5">
                                            @if(empty($program_id))
                                                <div class="pt-2">
                                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                                    Hubungkan ke Halaman Program (Opsional)
                                                </label>
                                                <select wire:model="program_page_id" 
                                                        class="cursor-pointer w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-white">
                                                    <option value="">Tidak Terhubung</option>
                                                    @foreach($relation_pages as $program)
                                                        <option value="{{ $program->id }}">{{ $program->title }}</option>
                                                    @endforeach
                                                </select>
                                                <p class="text-[10px] text-slate-500 mt-1">
                                                    *Jika memilih program, tombol akan otomatis mengarah ke detail program tersebut.
                                                </p>
                                            </div>
                                            @endif

                                            @php
                                                $templateList = \App\Livewire\Admin\LandingPage\Templates\LandingPageTemplate::all();
                                                @endphp

                                                @if(!$editMode)
                                                <select wire:model="templateType">
                                                    <option value="blank">Tanpa Template</option>

                                                    @foreach($templateList as $key => $template)
                                                        <option value="{{ $key }}">
                                                            {{ $template['label'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @endif

                                            <div class="pt-2">
                                                <label class="block text-sm font-semibold text-slate-700 mb-2">Fitur Tambahan</label>
                                                <div class="grid grid-cols-2 gap-3">
                                                    <label class="flex items-center gap-2.5 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100/70 transition-all select-none">
                                                        <input type="checkbox" wire:model="cart" class="w-4 h-4 rounded text-indigo-600 border-slate-300 focus:ring-indigo-500 accent-indigo-600 flex-shrink-0">
                                                        <span class="text-xs font-bold text-slate-700 truncate">Aktifkan Cart</span>
                                                    </label>

                                                    <label class="flex items-center gap-2.5 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100/70 transition-all select-none">
                                                        <input type="checkbox" wire:model="blog" class="w-4 h-4 rounded text-indigo-600 border-slate-300 focus:ring-indigo-500 accent-indigo-600 flex-shrink-0">
                                                        <span class="text-xs font-bold text-slate-700 truncate">Fitur Blog</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                {{-- ADVANCED TAB --}}
                                <div x-show="formTab==='advanced'" x-cloak class="bg-white">                                
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-6">
                                        <div>
                                            <label class="block text-xs font-black text-slate-400 uppercase mb-2">Meta Title</label>
                                            <input type="text" wire:model.live="meta_title" 
                                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all"
                                                placeholder="Masukkan judul meta...">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-black text-slate-400 uppercase mb-2">Robots Tag</label>
                                            <select wire:model="robots" 
                                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                                                <option value="index,follow">Index Follow</option>
                                                <option value="noindex,follow">NoIndex Follow</option>
                                                <option value="index,nofollow">Index NoFollow</option>
                                                <option value="noindex,nofollow">NoIndex NoFollow</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-black text-slate-400 uppercase mb-2">Canonical URL</label>
                                            <input type="url" wire:model="canonical_url" 
                                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all"
                                                placeholder="https://example.com/canonical-path">
                                            <p class="mt-1.5 text-[10px] text-slate-400 font-medium italic">Gunakan untuk menghindari konten duplikat.</p>
                                        </div>
                                    </div>

                                    <div class="space-y-6">
                                        <div>
                                            <label class="block text-xs font-black text-slate-400 uppercase mb-2">Meta Description</label>
                                            <textarea wire:model.live="meta_description" rows="4" 
                                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all"
                                                placeholder="Deskripsi singkat untuk mesin pencari..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                        {{-- FOOTER --}}
                        <div class="shrink-0 flex justify-end gap-3 p-6 border-t border-slate-200 bg-white">
                            <button
                                type="button"
                                wire:click="$set('openModal', false)"
                                class="px-6 py-2.5 rounded-xl border">
                                Batal
                            </button>

                            <button
                                type="submit"
                                class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl">
                                Simpan
                            </button>
                        </div>

                    </form>

                </div>

            </div>
        @endif
    </div>