<div class="p-4 space-y-4 max-w-xl mx-auto bg-white rounded-2xl">

    <div>
        <h4 class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2 flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-slate-400"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
            Basic
        </h4>
        <div class="grid grid-cols-2 gap-2">
            <button type="button" wire:click="addSection('text')" class="group cursor-pointer flex items-center gap-2.5 p-2.5 bg-slate-50/60 border border-slate-100 rounded-xl hover:border-indigo-500 hover:bg-indigo-50/40 transition-all text-left">
                <div class="p-1.5 bg-white rounded-lg border border-slate-100 text-slate-500 group-hover:text-indigo-600 group-hover:border-indigo-100 shadow-sm transition-colors flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 6.1H3"/><path d="M21 12.1H3"/><path d="M15.1 18H3"/></svg>
                </div>
                <span class="text-xs font-semibold text-slate-700 group-hover:text-indigo-950 transition-colors">Teks</span>
            </button>

            <button type="button" wire:click="addSection('image')" class="group cursor-pointer flex items-center gap-2.5 p-2.5 bg-slate-50/60 border border-slate-100 rounded-xl hover:border-indigo-500 hover:bg-indigo-50/40 transition-all text-left">
                <div class="p-1.5 bg-white rounded-lg border border-slate-100 text-slate-500 group-hover:text-indigo-600 group-hover:border-indigo-100 shadow-sm transition-colors flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                </div>
                <span class="text-xs font-semibold text-slate-700 group-hover:text-indigo-950 transition-colors">Gambar</span>
            </button>

            <button type="button" wire:click="addSection('video')" class="group cursor-pointer flex items-center gap-2.5 p-2.5 bg-slate-50/60 border border-slate-100 rounded-xl hover:border-indigo-500 hover:bg-indigo-50/40 transition-all text-left">
                <div class="p-1.5 bg-white rounded-lg border border-slate-100 text-slate-500 group-hover:text-indigo-600 group-hover:border-indigo-100 shadow-sm transition-colors flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m22 8-6 4 6 4V8Z"/><rect width="14" height="12" x="2" y="6" rx="2" ry="2"/></svg>
                </div>
                <span class="text-xs font-semibold text-slate-700 group-hover:text-indigo-950 transition-colors">Video</span>
            </button>

            <button type="button" wire:click="addSection('button')" class="group cursor-pointer flex items-center gap-2.5 p-2.5 bg-slate-50/60 border border-slate-100 rounded-xl hover:border-indigo-500 hover:bg-indigo-50/40 transition-all text-left">
                <div class="p-1.5 bg-white rounded-lg border border-slate-100 text-slate-500 group-hover:text-indigo-600 group-hover:border-indigo-100 shadow-sm transition-colors flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="12" x="2" y="6" rx="4"/></svg>
                </div>
                <span class="text-xs font-semibold text-slate-700 group-hover:text-indigo-950 transition-colors">Tombol</span>
            </button>
        </div>
    </div>

    <div class="border-t border-slate-100"></div>

    <div>
        <h4 class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2 flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-slate-400"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            Advanced
        </h4>
        <div class="grid grid-cols-2 gap-2">
            <button type="button" wire:click="addSection('product')" class="group cursor-pointer flex items-center gap-2.5 p-2.5 bg-slate-50/60 border border-slate-100 rounded-xl hover:border-indigo-500 hover:bg-indigo-50/40 transition-all text-left">
                <div class="p-1.5 bg-white rounded-lg border border-slate-100 text-slate-500 group-hover:text-indigo-600 group-hover:border-indigo-100 shadow-sm transition-colors flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                </div>
                <span class="text-xs font-semibold text-slate-700 group-hover:text-indigo-950 transition-colors">Produk 1</span>
            </button>

            <button type="button" wire:click="addSection('product2')" class="group cursor-pointer flex items-center gap-2.5 p-2.5 bg-slate-50/60 border border-slate-100 rounded-xl hover:border-indigo-500 hover:bg-indigo-50/40 transition-all text-left">
                <div class="p-1.5 bg-white rounded-lg border border-slate-100 text-slate-500 group-hover:text-indigo-600 group-hover:border-indigo-100 shadow-sm transition-colors flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="9" x="14" y="3" rx="1"/><rect width="7" height="9" x="3" y="14" rx="1"/><rect width="7" height="9" x="14" y="14" rx="1"/></svg>
                </div>
                <span class="text-xs font-semibold text-slate-700 group-hover:text-indigo-950 transition-colors">Produk 2</span>
            </button>

                <button type="button" wire:click="addSection('script')" class="group cursor-pointer flex items-center gap-2.5 p-2.5 bg-slate-50/60 border border-slate-100 rounded-xl hover:border-indigo-500 hover:bg-indigo-50/40 transition-all text-left">
                <div class="p-1.5 bg-white rounded-lg border border-slate-100 text-slate-500 group-hover:text-indigo-600 group-hover:border-indigo-100 shadow-sm transition-colors flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                </div>
                <span class="text-xs font-semibold text-slate-700 group-hover:text-indigo-950 transition-colors">Script</span>
            </button>
        </div>
    </div>

</div>