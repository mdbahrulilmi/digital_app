<div class="p-4 space-y-6 max-w-xl mx-auto bg-white rounded-2xl border border-slate-100 shadow-sm">
    @php
        // 1. LAYOUT: Fitur baru untuk ngatur tata letak
        $layout = [
            ['key' => 'section', 'label' => 'Section', 'icon' => '<rect width="20" height="14" x="2" y="5" rx="2"/><path d="M2 12h20"/>'],
            ['key' => 'col-2', 'label' => '2 Kolom', 'icon' => '<path d="M3 3h18v18H3z"/><path d="M12 3v18"/>'],
            ['key' => 'col-3', 'label' => '3 Kolom', 'icon' => '<path d="M3 3h18v18H3z"/><path d="M9 3v18M15 3v18"/>'],
        ];

        // 2. BASIC: Elemen konten dasar
        $basic = [
            ['key' => 'text', 'label' => 'Teks', 'icon' => '<path d="M17 6.1H3"/><path d="M21 12.1H3"/><path d="M15.1 18H3"/>'],
            ['key' => 'image', 'label' => 'Gambar', 'icon' => '<rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>'],
            ['key' => 'video', 'label' => 'Video', 'icon' => '<path d="m22 8-6 4 6 4V8Z"/><rect width="14" height="12" x="2" y="6" rx="2" ry="2"/>'],
            ['key' => 'button', 'label' => 'Tombol', 'icon' => '<rect width="20" height="12" x="2" y="6" rx="4"/>'],
        ];

        // 3. ADVANCED: Fitur khusus
        $advanced = [
            ['key' => 'product', 'label' => 'Produk', 'icon' => '<rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/>'],
            ['key' => 'script', 'label' => 'Embed Script', 'icon' => '<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>'],
        ];

        // 4. PROGRAMS: Fitur conditional dari database
        $programs = [];
        if (!empty($landingPage->program_id)) {
            $programs = [
                ['key' => 'program-detail', 'label' => 'Info Program', 'icon' => '<rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="9" x="14" y="3" rx="1"/><rect width="7" height="9" x="3" y="14" rx="1"/><rect width="7" height="9" x="14" y="14" rx="1"/>'],
                ['key' => 'button-checkout', 'label' => 'Tombol Checkout', 'icon' => '<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>']
            ];
        }

        $allSections = [
            'Layout' => $layout,
            'Basic Elements' => $basic,
            'Advanced' => $advanced,
            'Programs' => $programs
        ];
    @endphp

    @foreach($allSections as $title => $items)
        @if(!empty($items))
            <div>
                <h4 class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-3 ml-1">{{ $title }}</h4>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($items as $item)
                        <button type="button" 
                            wire:click="addSection('{{ $item['key'] }}')" 
                            class="{{ ($item['key'] == 'button-checkout' || $item['key'] == 'section') ? 'col-span-2' : '' }} group flex items-center gap-3 p-3 bg-white border border-slate-200 rounded-xl hover:border-emerald-500 hover:shadow-md transition-all text-left">
                            <div class="p-2 bg-slate-50 rounded-lg text-slate-400 group-hover:text-emerald-600 group-hover:bg-emerald-50 shadow-inner">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $item['icon'] !!}</svg>
                            </div>
                            <span class="text-xs font-semibold text-slate-700">{{ $item['label'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
</div>