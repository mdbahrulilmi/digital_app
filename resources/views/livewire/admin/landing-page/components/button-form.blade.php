<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 items-start">
    
    {{-- KOLOM KIRI: Pengaturan Konten & Tampilan Dasar --}}
    <div class="space-y-5">
        {{-- SECTION: Konten Tombol --}}
        <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm space-y-4">
            <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Konten</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Label Tombol</label>
                    <input type="text" wire:model.live="editingContent.text"
                        class="w-full text-sm px-3 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition"
                        placeholder="Contoh: Daftar Sekarang">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">URL Tujuan</label>
                    <input
                    type="text"
                    wire:model.live="editingContent.url"
                    @disabled($editingContent['url_disabled'] ?? false)
                    class="w-full text-sm px-3 py-2.5 border border-slate-200 rounded-xl
                        focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition

                        disabled:bg-slate-100
                        disabled:text-slate-500
                        disabled:border-slate-300
                        disabled:cursor-not-allowed
                        disabled:opacity-80"
                    placeholder="https://... atau /halaman">
                </div>
            </div>
        </div>

        {{-- SECTION: Warna --}}
        <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm space-y-3">
            <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Warna</h3>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Warna Latar</label>
                    <div class="flex items-center gap-2 border border-slate-200 rounded-xl px-2 py-1.5 focus-within:ring-2 focus-within:ring-indigo-400 transition">
                        <input type="color" wire:model.live="editingContent.bg_color"
                            class="w-8 h-8 rounded-lg border-0 cursor-pointer bg-transparent p-0 shrink-0">
                        <input type="text" wire:model.live="editingContent.bg_color"
                            class="w-full text-xs font-mono uppercase border-0 focus:outline-none bg-transparent text-slate-700"
                            placeholder="#4f46e5">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Warna Teks</label>
                    <div class="flex items-center gap-2 border border-slate-200 rounded-xl px-2 py-1.5 focus-within:ring-2 focus-within:ring-indigo-400 transition">
                        <input type="color" wire:model.live="editingContent.text_color"
                            class="w-8 h-8 rounded-lg border-0 cursor-pointer bg-transparent p-0 shrink-0">
                        <input type="text" wire:model.live="editingContent.text_color"
                            class="w-full text-xs font-mono uppercase border-0 focus:outline-none bg-transparent text-slate-700"
                            placeholder="#ffffff">
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm space-y-3">
            <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Tipografi & Bentuk</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Ukuran Teks</label>
                    <select wire:model.live="editingContent.font_size"
                        class="w-full text-sm px-3 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 transition bg-white">
                        <option value="12px">Kecil — 12px</option>
                        <option value="14px">Normal — 14px</option>
                        <option value="16px">Sedang — 16px</option>
                        <option value="18px">Besar — 18px</option>
                        <option value="20px">Sangat Besar — 20px</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Sudut (Radius)</label>
                    <select wire:model.live="editingContent.radius"
                        class="w-full text-sm px-3 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 transition bg-white">
                        <option value="0px">Kotak</option>
                        <option value="4px">Sedikit Lengkung</option>
                        <option value="8px">Standar</option>
                        <option value="12px">Halus</option>
                        <option value="9999px">Kapsul (Full)</option>
                    </select>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Alignment</label>
                    <div class="grid grid-cols-3 gap-1 border border-slate-200 rounded-xl p-1">
                        @foreach(['left' => '⬅', 'center' => '↔', 'right' => '➡'] as $val => $icon)
                        <label class="cursor-pointer">
                            <input type="radio" wire:model.live="editingContent.alignment" value="{{ $val }}" class="sr-only peer">
                            <span class="flex items-center justify-center py-1.5 text-sm rounded-lg peer-checked:bg-indigo-500 peer-checked:text-white text-slate-500 hover:bg-slate-100 transition select-none">
                                {{ $icon }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: Ukuran, Jarak & Live Preview --}}
    <div class="space-y-5">
        {{-- SECTION: Ukuran & Jarak --}}
        <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm space-y-4">
            <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Ukuran & Jarak</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Lebar</label>
                    <select wire:model.live="editingContent.width"
                        class="w-full text-sm px-3 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 transition bg-white">
                        <option value="auto">Otomatis</option>
                        <option value="150px">150px</option>
                        <option value="200px">200px</option>
                        <option value="300px">300px</option>
                    </select>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-xs font-semibold text-slate-500">Tinggi</label>
                        <span class="text-xs font-mono text-indigo-500 bg-indigo-50 px-2 py-0.5 rounded-md">{{ $editingContent['height'] ?? 'auto' }}px</span>
                    </div>
                    <input type="range" min="30" max="100" wire:model.live="editingContent.height"
                        class="w-full accent-indigo-600 mt-1">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-xs font-semibold text-slate-500">Padding Atas/Bawah</label>
                        <span class="text-xs font-mono text-indigo-500 bg-indigo-50 px-2 py-0.5 rounded-md">{{ $editingContent['padding_y'] ?? 10 }}px</span>
                    </div>
                    <input type="range" min="4" max="34" wire:model.live="editingContent.padding_y"
                        class="w-full accent-indigo-600">
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-xs font-semibold text-slate-500">Padding Kiri/Kanan</label>
                        <span class="text-xs font-mono text-indigo-500 bg-indigo-50 px-2 py-0.5 rounded-md">{{ $editingContent['padding_x'] ?? 20 }}px</span>
                    </div>
                    <input type="range" min="8" max="58" wire:model.live="editingContent.padding_x"
                        class="w-full accent-indigo-600">
                </div>
            </div>

            <label class="flex items-center gap-3 cursor-pointer select-none group">
                <div class="relative">
                    <input type="checkbox" wire:model.live="editingContent.full_width" class="sr-only peer">
                    <div class="w-10 h-6 bg-slate-200 rounded-full peer-checked:bg-indigo-500 transition-colors"></div>
                    <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                </div>
                <span class="text-xs font-semibold text-slate-600">Paksa Lebar Penuh (Full Block Width)</span>
            </label>
        </div>

        {{-- SECTION: Live Preview --}}
        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-5">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center mb-4">Live Preview</p>
            <div style="
                display: flex;
                width: 100%;
                justify-content: {{ ($editingContent['alignment'] ?? 'center') === 'left' ? 'flex-start' : (($editingContent['alignment'] ?? 'center') === 'right' ? 'flex-end' : 'center') }};
            ">
                <a href="#" onclick="return false;" style="
                    background: {{ $editingContent['bg_color'] ?? '#4f46e5' }};
                    color: {{ $editingContent['text_color'] ?? '#fff' }};
                    font-size: {{ $editingContent['font_size'] ?? '14px' }};
                    border-radius: {{ $editingContent['radius'] ?? '8px' }};
                    border: {{ $editingContent['border_width'] ?? '0px' }} solid {{ $editingContent['border_color'] ?? '#000' }};
                    width: {{ ($editingContent['full_width'] ?? false) ? '100%' : ($editingContent['width'] ?? 'auto') }};
                    height: {{ isset($editingContent['height']) ? $editingContent['height'].'px' : 'auto' }};
                    padding: {{ $editingContent['padding_y'] ?? 10 }}px {{ $editingContent['padding_x'] ?? 20 }}px;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    text-decoration: none;
                    font-weight: 600;
                    box-sizing: border-box;
                    box-shadow: {{ ($editingContent['shadow'] ?? true) ? '0 4px 10px rgba(0,0,0,.15)' : 'none' }};
                    transition: opacity .15s;
                ">
                    {{ $editingContent['text'] ?: 'Tombol Kosong' }}
                </a>
            </div>
        </div>
    </div>

</div>