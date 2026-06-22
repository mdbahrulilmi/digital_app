<div class="p-4 md:p-6 max-w-7xl mx-auto space-y-6">

    {{-- STAT CARDS --}}
    <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                ['bg' => '#EEEDFE', 'clr' => '#534AB7', 'label' => 'Produk', 'val' => $stats['produk'], 'icon' => 'archive-box'],
                ['bg' => '#E1F5EE', 'clr' => '#0F6E56', 'label' => 'Program aktif', 'val' => $stats['program_aktif'], 'icon' => 'bolt'],
                ['bg' => '#EAF3DE', 'clr' => '#3B6D11', 'label' => 'Program selesai', 'val' => $stats['program_selesai'], 'icon' => 'check-circle'],
                ['bg' => '#FAEEDA', 'clr' => '#854F0B', 'label' => 'Total program', 'val' => $stats['total_program'], 'icon' => 'squares-2x2'],
            ];
        @endphp

        @foreach($cards as $item)
        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm transition-transform hover:-translate-y-1 duration-200">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4" style="background: {{ $item['bg'] }}">
                @php $icon = 'heroicon-o-' . $item['icon']; @endphp
                <x-dynamic-component :component="$icon" class="w-5 h-5" style="color: {{ $item['clr'] }}" />
            </div>
            <div>
                <p class="text-[11px] uppercase tracking-wider font-semibold text-slate-400">{{ $item['label'] }}</p>
                <p class="text-3xl font-bold text-slate-900 mt-1">{{ $item['val'] }}</p>
            </div>
        </div>
        @endforeach
    </section>

    {{-- INFO CARDS --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach([
            ['clr' => '#D85A30', 'chip' => 'Aktif', 'label' => 'Program aktif', 'val' => 'Diet Sehat 30 Hari', 'icon' => 'fire'],
            ['clr' => '#378ADD', 'chip' => 'Hari 12', 'label' => 'Sesi berikutnya', 'val' => 'Diet Sehat', 'icon' => 'play'],
            ['clr' => '#7F77DD', 'chip' => 'Sesi 5', 'label' => 'Aktivitas terakhir', 'val' => 'Yoga', 'icon' => 'arrow-trending-up'],
        ] as $item)
        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:border-slate-200 transition-colors">
            <div class="flex items-center justify-between mb-4">
                @php $icon = 'heroicon-o-' . $item['icon']; @endphp
                <x-dynamic-component :component="$icon" class="w-6 h-6" style="color: {{ $item['clr'] }}" />
                <span class="text-[10px] font-bold uppercase px-3 py-1 rounded-full bg-slate-50 text-slate-600 border border-slate-100">
                    {{ $item['chip'] }}
                </span>
            </div>
            <p class="text-[11px] text-slate-400 mb-0.5">{{ $item['label'] }}</p>
            <p class="text-sm font-semibold text-slate-900">{{ $item['val'] }}</p>
        </div>
        @endforeach
    </section>

    {{-- JADWAL HARI INI --}}
    <section class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <x-heroicon-o-calendar-days class="w-4 h-4 text-indigo-500" />
                Jadwal hari ini
            </h2>
            <span class="text-[11px] font-medium text-slate-500 bg-slate-100 px-3 py-1 rounded-lg">Senin, 22 Juni 2026</span>
        </div>

        <div class="space-y-3">
            @forelse($jadwalHariIni as $jadwal)
                <div class="flex items-center gap-4 p-4 rounded-xl border {{ $jadwal->is_done ? 'border-slate-100' : 'border-teal-100 bg-teal-50/50' }}">
                    <div class="w-1 h-10 rounded-full {{ $jadwal->is_done ? 'bg-slate-200' : 'bg-teal-500' }} shrink-0"></div>
                    <div class="flex-1">
                        <p class="text-[13px] font-semibold text-slate-900">{{ $jadwal->title }}</p>
                        <p class="text-[11px] text-slate-500 flex items-center gap-1.5 mt-0.5">
                            <x-heroicon-o-clock class="w-3.5 h-3.5" /> 
                            {{ \Carbon\Carbon::parse($jadwal->start_time)->format('H:i') }} – 
                            {{ \Carbon\Carbon::parse($jadwal->end_time)->format('H:i') }}
                        </p>
                    </div>
                    <span class="text-[10px] font-bold px-3 py-1 rounded-full {{ $jadwal->is_done ? 'bg-slate-100 text-slate-500' : 'bg-teal-100 text-teal-700' }}">
                        {{ $jadwal->is_done ? 'Selesai' : 'Tersedia' }}
                    </span>
                </div>
            @empty
                <p class="text-slate-400 text-sm italic">Tidak ada jadwal untuk hari ini.</p>
            @endforelse
        </div>
    </section>
</div>