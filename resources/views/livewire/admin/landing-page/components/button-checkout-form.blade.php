<div class="space-y-5">
    {{-- SECTION: Konten Checkout --}}
    <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm space-y-4">
        <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Konten Checkout</h3>
        <div class="grid grid-cols-1 gap-3">
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Label Tombol</label>
                <input type="text" wire:model.live="editingContent.text" class="w-full text-sm px-3 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 transition" placeholder="Contoh: Beli Sekarang">
            </div>
        </div>
    </div>

    {{-- SECTION: Warna --}}
    <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm space-y-3">
        <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Warna</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Warna Latar</label>
                <div class="flex items-center gap-2 border border-slate-200 rounded-xl px-2 py-1.5 focus-within:ring-2 focus-within:ring-indigo-400">
                    <input type="color" wire:model.live="editingContent.bg_color" class="w-8 h-8 rounded-lg border-0 cursor-pointer bg-transparent p-0">
                    <input type="text" wire:model.live="editingContent.bg_color" class="w-full text-xs font-mono uppercase border-0 focus:outline-none bg-transparent text-slate-700">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Warna Teks</label>
                <div class="flex items-center gap-2 border border-slate-200 rounded-xl px-2 py-1.5 focus-within:ring-2 focus-within:ring-indigo-400">
                    <input type="color" wire:model.live="editingContent.text_color" class="w-8 h-8 rounded-lg border-0 cursor-pointer bg-transparent p-0">
                    <input type="text" wire:model.live="editingContent.text_color" class="w-full text-xs font-mono uppercase border-0 focus:outline-none bg-transparent text-slate-700">
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION: Tipografi & Bentuk --}}
    <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm space-y-3">
        <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Tipografi & Bentuk</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Ukuran Teks</label>
                <select wire:model.live="editingContent.font_size" class="w-full text-sm px-3 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white">
                    <option value="12px">12px</option>
                    <option value="14px">14px</option>
                    <option value="16px">16px</option>
                    <option value="18px">18px</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Radius</label>
                <select wire:model.live="editingContent.radius" class="w-full text-sm px-3 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white">
                    <option value="0px">Kotak</option>
                    <option value="8px">Standar</option>
                    <option value="9999px">Kapsul</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Alignment</label>
                <div class="grid grid-cols-3 gap-1 border border-slate-200 rounded-xl p-1">
                    @foreach(['left' => '⬅', 'center' => '↔', 'right' => '➡'] as $val => $icon)
                    <label class="cursor-pointer">
                        <input type="radio" wire:model.live="editingContent.alignment" value="{{ $val }}" class="sr-only peer">
                        <span class="flex items-center justify-center py-1.5 text-sm rounded-lg peer-checked:bg-indigo-500 peer-checked:text-white text-slate-500 hover:bg-slate-100 transition">
                            {{ $icon }}
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION: Ukuran & Jarak --}}
    <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm space-y-4">
        <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Ukuran & Jarak</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Lebar</label>
                <select wire:model.live="editingContent.width" class="w-full text-sm px-3 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white">
                    <option value="auto">Otomatis</option>
                    <option value="150px">150px</option>
                    <option value="300px">300px</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Tinggi</label>
                <input type="range" min="30" max="100" wire:model.live="editingContent.height" class="w-full accent-indigo-600 mt-2">
            </div>
        </div>
        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" wire:model.live="editingContent.full_width" class="sr-only peer">
            <div class="w-10 h-6 bg-slate-200 rounded-full peer-checked:bg-indigo-500 transition-colors"></div>
            <span class="text-xs font-semibold text-slate-600">Paksa Lebar Penuh</span>
        </label>
    </div>

    {{-- SECTION: Live Preview --}}
    <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-5">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center mb-4">Live Preview</p>
        <div class="flex" style="justify-content: {{ ($editingContent['alignment'] ?? 'center') === 'left' ? 'flex-start' : (($editingContent['alignment'] ?? 'right') === 'right' ? 'flex-end' : 'center') }}">
            <a href="#" onclick="return false;" style="
                background: {{ $editingContent['bg_color'] ?? '#4f46e5' }};
                color: {{ $editingContent['text_color'] ?? '#fff' }};
                font-size: {{ $editingContent['font_size'] ?? '14px' }};
                border-radius: {{ $editingContent['radius'] ?? '8px' }};
                width: {{ ($editingContent['full_width'] ?? false) ? '100%' : ($editingContent['width'] ?? 'auto') }};
                height: {{ isset($editingContent['height']) ? $editingContent['height'].'px' : 'auto' }};
                padding: {{ $editingContent['padding_y'] ?? 10 }}px {{ $editingContent['padding_x'] ?? 20 }}px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                font-weight: 600;
                box-shadow: 0 4px 10px rgba(0,0,0,.15);
            ">
                {{ $editingContent['text'] ?: 'Tombol Checkout' }}
            </a>
        </div>
    </div>
</div>