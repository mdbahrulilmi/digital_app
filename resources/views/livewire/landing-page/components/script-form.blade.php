<div class="space-y-4">
    <div class="flex flex-wrap items-center justify-between gap-4 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600 border border-indigo-100 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Custom Script Editor</h4>
                <p class="text-[10px] text-slate-500 font-medium">Skrip HTML, JavaScript</p>
            </div>
        </div>

        @php
            $scriptCode = $editingContent['script'] ?? '';
            $lineCount = !empty($scriptCode) ? count(explode("\n", $scriptCode)) : 1;
        @endphp
        <div class="flex items-center gap-2 text-[11px] font-mono bg-slate-50 px-2.5 py-1 rounded-md border border-slate-200 text-slate-600">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>{{ $lineCount }} Baris Kode</span>
        </div>
    </div>

    <div>
        <div class="relative rounded-xl border border-slate-200 bg-white overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500/20 focus-within:border-indigo-500 transition-all shadow-sm">
            
            <div class="flex items-center justify-between px-4 py-2 bg-slate-50 border-b border-slate-200 text-[11px] font-mono text-slate-400 select-none">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-400"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                    <span class="ml-2 font-medium border-b-2 border-indigo-600 pb-2 -mb-2 px-1 text-slate-700">script</span>
                </div>
                <span class="text-indigo-600 font-semibold text-[10px] bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">HTML / JS</span>
            </div>
            
            <textarea 
                wire:model.live="editingContent.script"
                rows="12" 
                class="w-full block px-4 py-3 bg-slate-50/50 text-indigo-950 font-mono text-xs leading-relaxed focus:outline-none resize-y placeholder-slate-400 min-h-[250px]"
                placeholder=""
            ></textarea>
            
        </div>
    </div>
</div>