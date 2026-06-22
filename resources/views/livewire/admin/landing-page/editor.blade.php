<div class="p-6 max-w-7xl mx-auto">
    
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $landingPage->title }}</h1>
            <p class="text-sm text-slate-500">Susun urutan seksi dan kelola komponen halaman utama secara visual.</p>
        </div>
        
        {{-- <div class="flex gap-3">
            <button class="cursor-pointer px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold transition-all text-sm">
                Pratinjau Penuh
            </button>
            <button class="cursor-pointer px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold transition-all shadow-md shadow-indigo-200 text-sm">
                Publikasikan Perubahan
            </button>
        </div> --}}
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        {{-- PANEL KIRI: STRUKTUR HALAMAN --}}
        <div class="lg:col-span-5 space-y-4">
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Struktur Halaman</h3>
                        <p class="text-xs text-slate-400">Atur susunan seksi landing page Anda.</p>
                    </div>
                    
                    <button 
                        type="button"
                        wire:click="$set('openComponentModal', true)"
                        class="cursor-pointer flex items-center gap-1 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold transition-all shadow-sm shadow-indigo-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Section
                    </button>
                </div>

                <div id="section-list" class="space-y-2.5">
                    @foreach($landingPage->sections as $section)
                        <div data-id="{{ $section->id }}" class="flex items-center justify-between p-3 border border-slate-200 rounded-xl transition-all group {{ !$section->is_visible ? 'opacity-50 bg-slate-100/70' : 'bg-slate-50 hover:bg-white hover:border-slate-300' }}">
                            <div class="flex items-center gap-3">
                                <div class="sort-handle text-slate-400 group-hover:text-slate-600 cursor-grab active:cursor-grabbing">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6h16.5" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-700">{{ $section->name }}</p>
                                    <span class="text-[10px] font-medium text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded capitalize">{{ $section->type }}</span>
                                </div>
                            </div>
                            
                            <div class="flex gap-1">
                                <button wire:click="editContent({{ $section->id }})" class="cursor-pointer p-1.5 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edit Konten">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                    </svg>
                                </button>

                                <button wire:click="toggleVisibility({{ $section->id }})" class="cursor-pointer p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-slate-100 rounded-lg transition-all">
                                    @if($section->is_visible)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                        </svg>
                                    @endif
                                </button>
                                
                                <button wire:click="deleteSection({{ $section->id }})" wire:confirm="Yakin ingin menghapus seksi ini?" class="cursor-pointer p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- PANEL KANAN: SIMULATOR MOCKUP SMARTPHONE --}}
        <div class="lg:col-span-7 flex justify-center items-center p-6 bg-slate-100 rounded-2xl border border-slate-200">
            <div class="w-full max-w-md h-[700px] bg-white shadow-2xl rounded-[2.5rem] border-[10px] border-slate-800 relative flex flex-col overflow-hidden select-none">
                
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 h-4 w-32 bg-slate-800 rounded-b-xl z-50"></div>

                <div class="flex-1 overflow-y-auto pt-6 scrollbar-none bg-white">
                    {{-- FIXED FIX: Menggunakan blank() agar aman dari passing data bernilai null --}}
                    @if(blank($landingPage->sections))
                        <div class="flex flex-col items-center justify-center h-full text-slate-400 p-6 text-center">
                            <span class="text-3xl mb-2">📱</span>
                            <p class="text-xs">Belum ada komponen. Tambahkan komponen di sebelah kiri untuk melihat pratinjau.</p>
                        </div>
                    @else
                        @foreach($landingPage->sections as $section)
                            {{-- Hanya tampilkan komponen pratinjau jika status visibilitasnya TRUE --}}
                            @if($section->is_visible)

                                {{-- B. TEXT BLOCK SECTION PREVIEW --}}
                                @if($section->type === 'text')
                                    @include('livewire.admin.landing-page.components.text-preview', [
                                        'section' => $section
                                    ])
                                @endif

                                @if($section->type === 'image')
                                    @include('livewire.admin.landing-page.components.image-preview', [
                                        'section' => $section
                                    ])
                                @endif

                                @if($section->type === 'video')
                                    @include('livewire.admin.landing-page.components.video-preview', [
                                        'section' => $section
                                    ])
                                @endif

                                {{-- E. BUTTON SECTION PREVIEW --}}
                                @if($section->type === 'button')
                                   @include('livewire.admin.landing-page.components.button-preview', [
                                        'section' => $section
                                    ])
                                @endif
                                
                                @if($section->type === 'product')
                                   @include('livewire.admin.landing-page.components.product-preview', [
                                        'section' => $section
                                    ])
                                @endif
                                
                                @if($section->type === 'product2')
                                   @include('livewire.admin.landing-page.components.product2-preview', [
                                        'section' => $section
                                    ])
                                @endif
                                
                                @if($section->type === 'program')
                                   @include('livewire.admin.landing-page.components.program-preview', [
                                        'section' => $section
                                    ])
                                @endif
                                
                                @if($section->type === 'program2')
                                   @include('livewire.admin.landing-page.components.program2-preview', [
                                        'section' => $section
                                    ])
                                @endif

                                @if($section->type === 'button_checkout')
                                   @include('livewire.admin.landing-page.components.button-checkout-preview', [
                                        'section' => $section,
                                        'isPreview' => true
                                    ])
                                @endif
                                
                                @if($section->type === 'script')
                                   @include('livewire.admin.landing-page.components.script-preview', [
                                        'section' => $section
                                    ])
                                @endif

                            @endif
                        @endforeach
                    @endif
                </div>

                <div class="bg-white py-2 flex justify-center items-center border-t border-slate-50">
                    <div class="w-28 h-1 bg-slate-300 rounded-full"></div>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL DIALOG: EDIT KONTEN --}}
    @if($openEditModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
        <div class="bg-white w-full max-w-5xl rounded-2xl shadow-xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <div>
                    <h4 class="text-base font-bold text-slate-800">Edit Isi Konten</h4>
                    <p class="text-xs text-slate-400">{{ $editingSectionName }}</p>
                </div>
                <button wire:click="$set('openEditModal', false)" class="cursor-pointer text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="saveContent" class="p-6 space-y-4">
                @php 
                    $currentType = $landingPage->sections->firstWhere('id', $this->editingSectionId)?->type;
                @endphp

                @if($currentType === 'text')
                    @include('livewire.admin.landing-page.components.text-form')
                @endif

                @if($currentType === 'image')
                    @include('livewire.admin.landing-page.components.image-form')
                @endif
                
                @if($currentType === 'video')
                    @include('livewire.admin.landing-page.components.video-form')
                @endif

                @if($currentType === 'button')
                    @include('livewire.admin.landing-page.components.button-form')
                @endif
                
                @if($currentType === 'product')
                    @include('livewire.admin.landing-page.components.product-form')
                @endif
               
                @if($currentType === 'product2')
                    @include('livewire.admin.landing-page.components.product2-form')
                @endif
                
                @if($currentType === 'program')
                    @include('livewire.admin.landing-page.components.program-form')
                @endif
               
                @if($currentType === 'program2')
                    @include('livewire.admin.landing-page.components.program2-form')
                @endif
                
                @if($currentType === 'button_checkout')
                    @include('livewire.admin.landing-page.components.button-checkout-form')
                @endif
                
                @if($currentType === 'script')
                    @include('livewire.admin.landing-page.components.script-form')
                @endif

                <div class="pt-2 flex justify-end gap-2 border-t border-slate-100">
                    <button type="button" wire:click="$set('openEditModal', false)" class="cursor-pointer px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-200">
                        Batal
                    </button>
                    <button type="submit" class="cursor-pointer px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold hover:bg-indigo-700 shadow shadow-indigo-100">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
    @if($openComponentModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <h4 class="text-base font-bold text-slate-800">Tambah Komponen Section</h4>
                <button wire:click="$set('openComponentModal', false)" class="cursor-pointer text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            @include('livewire.admin.landing-page.components.modal.components')
            
        </div>
    </div>
    @endif

    {{-- CSS STYLING & CORE PLUGIN ASSETS --}}
    <style>
        .pell-actionbar { background-color: #f8fafc !important; border-bottom: 1px solid #e2e8f0 !important; display: flex; flex-wrap: wrap; }
        .pell-button { border: none !important; background-color: transparent !important; height: 36px !important; width: 36px !important; color: #475569 !important; font-weight: bold; cursor: pointer; }
        .pell-button-selected { background-color: #e2e8f0 !important; }
        .pell-content { min-height: 180px !important; padding: 12px !important; outline: none !important; background-color: #fff; }
        
        .pell-content ul, .rich-text-output ul { list-style-type: disc !important; padding-left: 20px !important; margin-bottom: 8px; }
        .pell-content ... ol, .rich-text-output ol { list-style-type: decimal !important; padding-left: 20px !important; margin-bottom: 8px; }
        .pell-content h1, .rich-text-output h1 { font-size: 1.4rem !important; font-weight: bold !important; margin-top: 8px; }
        .pell-content h2, .rich-text-output h2 { font-size: 1.2rem !important; font-weight: bold !important; margin-top: 6px; }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }

        .rich-text-output ul { list-style-type: disc !important; padding-left: 20px !important; margin-bottom: 12px; }
        .rich-text-output ol { list-style-type: decimal !important; padding-left: 20px !important; margin-bottom: 12px; }
        .rich-text-output h1 { font-size: 1.3rem !important; font-weight: bold !important; margin-top: 12px; margin-bottom: 6px; color: #1e293b; }
        .rich-text-output h2 { font-size: 1.15rem !important; font-weight: bold !important; margin-top: 10px; margin-bottom: 4px; color: #1e293b; }
        .rich-text-output p { margin-bottom: 8px; line-height: 1.6 !important; }
        .rich-text-output strong { font-weight: 700; color: #0f172a; }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/pell/dist/pell.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script src="https://unpkg.com/pell"></script>
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

    <script>
        function initSortable() {
            const el = document.getElementById('section-list');
            if (el) {
                Sortable.create(el, {
                    handle: '.sort-handle',
                    animation: 150,
                    onEnd: function (evt) {
                        const orderedIds = Array.from(el.querySelectorAll('[data-id]')).map(item => item.getAttribute('data-id'));
                        Livewire.dispatch('updateSectionsOrder', { orderedIds: orderedIds });
                    }
                });
            }
        }

        document.addEventListener('livewire:navigated', () => {
            initSortable();
        });

        document.addEventListener('livewire:update', () => {
            window.dispatchEvent(new CustomEvent('init-pell'));
        });
    </script>
</div>