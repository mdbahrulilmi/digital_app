<div class="p-4 space-y-6 max-w-xl mx-auto bg-white rounded-2xl border border-slate-100 shadow-sm">
    @php
        $basic = [
            ['key' => 'text', 'label' => 'Teks', 'icon' => '<path d="M17 6.1H3"/><path d="M21 12.1H3"/><path d="M15.1 18H3"/>'],
            ['key' => 'image', 'label' => 'Gambar', 'icon' => '<rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>'],
            ['key' => 'video', 'label' => 'Video', 'icon' => '<path d="m22 8-6 4 6 4V8Z"/><rect width="14" height="12" x="2" y="6" rx="2" ry="2"/>'],
            ['key' => 'button', 'label' => 'Tombol', 'icon' => '<rect width="20" height="12" x="2" y="6" rx="4"/>'],
        ];

        $advanced = [
            ['key' => 'product', 'label' => 'Produk 1', 'icon' => '<rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/>'],
            ['key' => 'product2', 'label' => 'Produk 2', 'icon' => '<rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/>'],
            ['key' => 'program', 'label' => 'Program 1', 'icon' => '<rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="9" x="14" y="3" rx="1"/><rect width="7" height="9" x="3" y="14" rx="1"/><rect width="7" height="9" x="14" y="14" rx="1"/>'],
            ['key' => 'program2', 'label' => 'Program 2', 'icon' => '<rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="9" x="14" y="3" rx="1"/><rect width="7" height="9" x="3" y="14" rx="1"/><rect width="7" height="9" x="14" y="14" rx="1"/>'],
            ['key' => 'script', 'label' => 'Script', 'icon' => '<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>'],
        ];

        $allSections = [
            'Basic Elements' => $basic,
            'Advanced' => $advanced
        ];

        if (!empty($landingPage->program_id)) {
            $allSections['Programs'] = [
                ['key' => 'button_checkout', 'label' => 'Tombol Checkout', 'icon' => '<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>']
            ];
        }
    @endphp

    @foreach($allSections as $title => $items)
        <div>
            <h4 class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-3">{{ $title }}</h4>
            <div class="grid grid-cols-2 gap-2">
                @foreach($items as $item)
                    <button type="button" wire:click="addSection('{{ $item['key'] }}')" class="{{ ($item['key'] == 'button_checkout') ? 'col-span-2' : '' }} group flex items-center gap-3 p-2.5 bg-slate-50 border border-slate-100 rounded-xl hover:border-emerald-500 hover:bg-emerald-50/50 transition-all text-left">
                        <div class="p-1.5 bg-white rounded-lg border border-slate-200 text-slate-400 group-hover:text-emerald-600 shadow-sm">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $item['icon'] !!}</svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-700">{{ $item['label'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    @endforeach
</div>