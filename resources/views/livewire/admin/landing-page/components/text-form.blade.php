<div class="space-y-4">
    
    <div>
        <label class="block text-xs font-bold text-slate-600 uppercase mb-2">
            Isi Teks Paragraf (Preview)
        </label>
        
        @php
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

    <div class="flex flex-wrap items-center gap-4 bg-slate-50 p-4 rounded-xl border border-slate-200">
        
        <div class="flex items-center gap-1.5">
            <label class="text-[11px] font-bold text-slate-500 uppercase">Font:</label>
            <select wire:model.live="editingContent.font_family" class="text-xs border border-slate-200 rounded-lg p-1.5 bg-white focus:outline-none focus:border-indigo-500">
                <option value="font-sans">Sans Serif</option>
                <option value="font-serif">Serif</option>
                <option value="font-mono">Monospace</option>
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
            <label class="text-[11px] font-bold text-slate-500 uppercase">Spasi:</label>
            <select wire:model.live="editingContent.line_height" class="text-xs border border-slate-200 rounded-lg p-1.5 bg-white focus:outline-none focus:border-indigo-500">
                <option value="leading-none">Rapat</option>
                <option value="leading-normal">Normal</option>
                <option value="leading-relaxed">Renggang</option>
                <option value="leading-loose">Sangat Renggang</option>
            </select>
        </div>

        <div class="h-4 w-px bg-slate-300 hidden md:block"></div>

        <div class="flex items-center gap-1">
            <button type="button" wire:click="$set('editingContent.is_bold', {{ !($editingContent['is_bold'] ?? false) ? 'true' : 'false' }})" class="w-8 h-8 rounded-lg border text-xs font-bold transition {{ ($editingContent['is_bold'] ?? false) ? 'bg-indigo-50 border-indigo-300 text-indigo-600' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-100' }}">B</button>
            <button type="button" wire:click="$set('editingContent.is_italic', {{ !($editingContent['is_italic'] ?? false) ? 'true' : 'false' }})" class="w-8 h-8 rounded-lg border text-xs italic transition {{ ($editingContent['is_italic'] ?? false) ? 'bg-indigo-50 border-indigo-300 text-indigo-600' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-100' }}">I</button>
            <button type="button" wire:click="$set('editingContent.is_underline', {{ !($editingContent['is_underline'] ?? false) ? 'true' : 'false' }})" class="w-8 h-8 rounded-lg border text-xs underline transition {{ ($editingContent['is_underline'] ?? false) ? 'bg-indigo-50 border-indigo-300 text-indigo-600' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-100' }}">U</button>
        </div>

        <div class="h-4 w-px bg-slate-300 hidden md:block"></div>

        <div class="flex items-center gap-1">
            @foreach(['text-left' => 'Kiri', 'text-center' => 'Tengah', 'text-right' => 'Kanan', 'text-justify' => 'Justify'] as $val => $label)
                <button type="button" wire:click="$set('editingContent.alignment', '{{ $val }}')" class="px-2.5 py-1.5 text-xs border transition {{ ($editingContent['alignment'] ?? 'text-left') === $val ? 'bg-indigo-500 border-indigo-500 text-white' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-100' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div class="h-4 w-px bg-slate-300 hidden md:block"></div>

        <div class="flex items-center gap-1.5">
            <label class="text-[11px] font-bold text-slate-500 uppercase">Warna:</label>
            <div class="flex items-center gap-1 border border-slate-200 p-1 bg-white rounded-lg">
                <input type="color" wire:model.live="editingContent.text_color" class="w-6 h-6 p-0 border-0 rounded cursor-pointer bg-transparent">
            </div>
        </div>
    </div>
</div>