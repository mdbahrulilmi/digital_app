<div class="space-y-4">
    <div class="flex flex-wrap items-center gap-4 bg-slate-50 p-4 rounded-xl border border-slate-200">
        
        <div class="flex items-center gap-1.5">
            <label class="text-[11px] font-bold text-slate-500 uppercase">Font:</label>
            <select wire:model.live="editingContent.font_family" class="text-xs border border-slate-200 rounded-lg p-1.5 bg-white focus:outline-none focus:border-indigo-500">
                <option value="font-sans">Sans Serif (Modern)</option>
                <option value="font-serif">Serif (Klasik/Koran)</option>
                <option value="font-mono">Monospace (Code)</option>
            </select>
        </div>

        <div class="flex items-center gap-1.5">
            <label class="text-[11px] font-bold text-slate-500 uppercase">Ukuran:</label>
            <select wire:model.live="editingContent.font_size" class="text-xs border border-slate-200 rounded-lg p-1.5 bg-white focus:outline-none focus:border-indigo-500">
                <option value="text-xs">Sangat Kecil</option>
                <option value="text-sm">Kecil</option>
                <option value="text-base">Normal</option>
                <option value="text-lg">Agak Besar</option>
                <option value="text-xl">Besar</option>
                <option value="text-2xl">Sangat Besar</option>
            </select>
        </div>

        <div class="flex items-center gap-1.5">
            <label class="text-[11px] font-bold text-slate-500 uppercase">Spasi Baris:</label>
            <select wire:model.live="editingContent.line_height" class="text-xs border border-slate-200 rounded-lg p-1.5 bg-white focus:outline-none focus:border-indigo-500">
                <option value="leading-none">Rapat</option>
                <option value="leading-tight">Agak Rapat</option>
                <option value="leading-normal">Normal</option>
                <option value="leading-relaxed">Renggang (Default)</option>
                <option value="leading-loose">Sangat Renggang</option>
            </select>
        </div>

        <div class="h-4 w-px bg-slate-300 hidden md:block"></div>

        <div class="flex items-center gap-1">
            <button type="button"
                wire:click="$set('editingContent.is_bold', {{ !($editingContent['is_bold'] ?? false) ? 'true' : 'false' }})"
                class="w-8 h-8 rounded-lg border text-xs font-bold transition {{ ($editingContent['is_bold'] ?? false) ? 'bg-indigo-50 border-indigo-300 text-indigo-600' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-100' }}"
                title="Tebal">
                B
            </button>

            <button type="button"
                wire:click="$set('editingContent.is_italic', {{ !($editingContent['is_italic'] ?? false) ? 'true' : 'false' }})"
                class="w-8 h-8 rounded-lg border text-xs italic transition {{ ($editingContent['is_italic'] ?? false) ? 'bg-indigo-50 border-indigo-300 text-indigo-600' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-100' }}"
                title="Miring">
                I
            </button>

            <button type="button"
                wire:click="$set('editingContent.is_underline', {{ !($editingContent['is_underline'] ?? false) ? 'true' : 'false' }})"
                class="w-8 h-8 rounded-lg border text-xs underline transition {{ ($editingContent['is_underline'] ?? false) ? 'bg-indigo-50 border-indigo-300 text-indigo-600' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-100' }}"
                title="Garis Bawah">
                U
            </button>
        </div>

        <div class="h-4 w-px bg-slate-300 hidden md:block"></div>

        <div class="flex items-center gap-1">
            <button type="button" wire:click="$set('editingContent.alignment', 'text-left')"
                class="px-2.5 py-1.5 text-xs border rounded-l-lg transition {{ ($editingContent['alignment'] ?? 'text-left') === 'text-left' ? 'bg-indigo-500 border-indigo-500 text-white' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-100' }}">
                Kiri
            </button>
            <button type="button" wire:click="$set('editingContent.alignment', 'text-center')"
                class="px-2.5 py-1.5 text-xs border-y transition {{ ($editingContent['alignment'] ?? 'text-left') === 'text-center' ? 'bg-indigo-500 border-indigo-500 text-white' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-100' }}">
                Tengah
            </button>
            <button type="button" wire:click="$set('editingContent.alignment', 'text-right')"
                class="px-2.5 py-1.5 text-xs border transition {{ ($editingContent['alignment'] ?? 'text-left') === 'text-right' ? 'bg-indigo-500 border-indigo-500 text-white' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-100' }}">
                Kanan
            </button>
            <button type="button" wire:click="$set('editingContent.alignment', 'text-justify')"
                class="px-2.5 py-1.5 text-xs border rounded-r-lg transition {{ ($editingContent['alignment'] ?? 'text-left') === 'text-justify' ? 'bg-indigo-500 border-indigo-500 text-white' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-100' }}">
                Justify
            </button>
        </div>

        <div class="h-4 w-px bg-slate-300 hidden md:block"></div>

        <div class="flex items-center gap-1.5">
            <label class="text-[11px] font-bold text-slate-500 uppercase">Warna Teks:</label>
            <div class="flex items-center gap-1 border border-slate-200 p-1 bg-white rounded-lg">
                <input type="color" wire:model.live="editingContent.text_color" class="w-6 h-6 p-0 border-0 rounded cursor-pointer bg-transparent">
                <span class="text-xs text-slate-500 font-mono pr-1">{{ $editingContent['text_color'] ?? '#334155' }}</span>
            </div>
        </div>
    </div>

    <div>
        <label class="block text-xs font-bold text-slate-600 uppercase mb-2">
            Isi Teks Paragraf
        </label>
        
        @php
            // Membaca konfigurasi style yang aktif secara live dari Livewire State
            $fontFamily  = $editingContent['font_family'] ?? 'font-sans';
            $fontSize    = $editingContent['font_size'] ?? 'text-sm';
            $lineHeight  = $editingContent['line_height'] ?? 'leading-relaxed';
            $alignment   = $editingContent['alignment'] ?? 'text-left';
            $fontWeight  = (!empty($editingContent['is_bold']) && $editingContent['is_bold'] == true) ? 'font-bold' : 'font-normal';
            $fontStyle   = (!empty($editingContent['is_italic']) && $editingContent['is_italic'] == true) ? 'italic' : 'not-italic';
            $fontDecor   = (!empty($editingContent['is_underline']) && $editingContent['is_underline'] == true) ? 'underline' : 'no-underline';
            $textColor   = $editingContent['text_color'] ?? '#334155';
        @endphp

        <textarea 
            wire:model="editingContent.text"
            rows="8" 
            class="w-full h-48 px-4 py-3 border border-slate-200 rounded-xl bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-150 ease-in-out placeholder-slate-400 resize-none {{ $fontFamily }} {{ $fontSize }} {{ $lineHeight }} {{ $alignment }} {{ $fontWeight }} {{ $fontStyle }} {{ $fontDecor }}"
            style="color: {{ $textColor }};"
            placeholder="Ketik konten teks di sini..."
        ></textarea>
    </div>
</div>