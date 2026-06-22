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

    @if($showPasswordModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900 bg-opacity-50 backdrop-blur-sm">
            <div class="bg-white p-6 rounded-xl shadow-2xl w-full max-w-sm">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Keamanan Akun</h2>
                
                <p class="text-sm text-gray-600 mb-4">
                    Password Anda saat ini masih menggunakan <strong>Nomor WhatsApp</strong> Anda. 
                    Demi keamanan, kami sangat menyarankan Anda untuk menggantinya sekarang.
                </p>
                
                <form wire:submit.prevent="updatePassword" class="space-y-4">
                    <div>
                        <input type="password" wire:model="newPassword" placeholder="Masukkan password baru" 
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                        @error('newPassword') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                            Ubah Password
                        </button>
                        
                        <button type="button" wire:click="closeModal" 
                            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 rounded-lg transition">
                            Tetap Pakai Password Lama
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>