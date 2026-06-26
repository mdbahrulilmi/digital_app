<div x-data="{
    height: {{ (int) (preg_match('/<!--\s*height:(\d+)\s*-->/', $editingContent['script'] ?? '', $m) ? $m[1] : 100) }},
    updateHeight(value) {
        let ta = this.$refs.script;

        if (!ta.value.match(/<!--\s*height:\d+\s*-->/)) {
            ta.value = `<!-- height:${value} -->\n\n` + ta.value;
        } else {
            ta.value = ta.value.replace(
                /<!--\s*height:\d+\s*-->/,
                `<!-- height:${value} -->`
            );
        }

        ta.dispatchEvent(new Event('input', { bubbles: true }));
    }
}"> 
<div class="space-y-4">

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
    
            <div class="flex items-center gap-4 w-full sm:w-auto">
                <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600 border border-indigo-100 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="16 18 22 12 16 6"/>
                        <polyline points="8 6 2 12 8 18"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-[11px] font-black text-slate-800 uppercase tracking-widest">Custom Script Editor</h4>
                    <p class="text-[10px] text-slate-400 font-medium">Konfigurasi HTML & JavaScript</p>
                </div>
            </div>

            <div class="flex items-center gap-4 w-full sm:w-auto justify-between sm:justify-end">
                
                <div class="flex flex-col">
                    <label class="text-[9px] font-black text-slate-400 uppercase mb-1">Tinggi (px)</label>
                    <input
                        type="number"
                        min="1"
                        step="1"
                        class="rounded-xl border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-700 w-24 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none"
                        placeholder="100"
                        x-model="height"
                        @input="if ($event.target.value === '' || $event.target.value < 1) { $event.target.value = 1; } updateHeight($event.target.value)"
                    >
                </div>

                @php
                    $scriptCode = $editingContent['script'] ?? '';
                    $lineCount = !empty($scriptCode) ? count(explode("\n", $scriptCode)) : 1;
                @endphp

                <div class="flex flex-col">
                    <span class="text-[9px] font-black text-slate-400 uppercase mb-1">Status</span>
                    <div class="flex items-center gap-2 text-[10px] font-black bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-200 text-slate-600">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        {{ $lineCount }} Baris
                    </div>
                </div>
            </div>
        </div>

        <div class="relative rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm">

            <div class="flex items-center justify-between px-4 py-2 bg-slate-50 border-b border-slate-200">
                <span class="text-xs font-medium text-slate-700">
                    script
                </span>
            </div>

            <textarea
                x-ref="script"
                wire:model.live="editingContent.script"
                rows="12"
                class="w-full block px-4 py-3 bg-slate-50/50 text-indigo-950 font-mono text-xs leading-relaxed focus:outline-none resize-y min-h-[250px]"
            ></textarea>

        </div>
    </div>
</div>