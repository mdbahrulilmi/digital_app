@php
    $hasLive = isset($sessions['live']) && count($sessions['live']) > 0;
@endphp

<div class="w-full px-6 py-10">
    <div class="mb-10">
        <h2 class="text-4xl font-black text-slate-900 tracking-tight">Jadwal Webinar</h2>
    </div>

    @foreach(['live' => 'Sedang Berlangsung', 'soon' => 'Segera Hadir', 'upcoming' => 'Akan Datang', 'past' => 'Selesai'] as $status => $label)
        @if(isset($sessions[$status]) && count($sessions[$status]))
            <div class="mb-12">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">{{ $label }}</h3>

                <div class="grid gap-6">
                    @foreach($sessions[$status] as $session)
                        @php
                            $isLive = $status === 'live';
                            $isSoon = $status === 'soon';
                            $isPast = $status === 'past';
                            $hasRecording = !empty($session->recording_url);
                            $targetMs = \Carbon\Carbon::parse($session->date . ' ' . $session->start_time)->timestamp * 1000;
                        @endphp

                        <div x-data="countdown({{ $targetMs }}, {{ $isPast ? 'true' : 'false' }})" x-init="start()"
                             class="relative overflow-hidden rounded-2xl p-8 flex flex-col md:flex-row gap-8 items-center border shadow-sm
                             {{ $isLive ? 'bg-[#0e71eb] text-white shadow-2xl border-[#0e71eb]' : 'bg-white border-slate-200 text-slate-900' }}">
                            
                            {{-- Ornamen Premium untuk Live --}}
                            @if($isLive)
                                <div class="absolute -top-12 -right-12 w-48 h-48 bg-white opacity-20 rounded-full blur-3xl"></div>
                                <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
                            @endif

                            {{-- Icon --}}
                            <div class="w-20 h-20 rounded-2xl flex items-center justify-center shrink-0 z-10 
                                 {{ $isLive ? 'bg-white text-[#0e71eb]' : 'bg-slate-100 text-slate-400' }}">
                                <x-heroicon-o-video-camera class="w-10 h-10" />
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 w-full z-10">
                                @if($isLive)
                                    <div class="flex items-center gap-2 mb-3">
                                        <div class="px-3 py-1 bg-white text-[#0e71eb] text-[10px] font-black rounded-full uppercase tracking-widest animate-pulse">
                                            LIVE NOW
                                        </div>
                                    </div>
                                @endif
                                <h4 class="text-2xl font-black leading-tight">{{ $session->title }}</h4>
                                <div class="mt-2 text-sm opacity-90 font-medium">
                                    {{ \Carbon\Carbon::parse($session->date)->translatedFormat('d F Y') }} • 
                                    {{ substr($session->start_time, 0, 5) }} - {{ substr($session->end_time, 0, 5) }} WIB
                                </div>
                            </div>

                            {{-- Sisi Kanan: Countdown + Tombol (Sejajar) --}}
                            <div class="flex items-center gap-6 shrink-0 z-10">
                                @if($isSoon)
                                    <div class="flex gap-4">
                                        @foreach(['days' => 'Hari', 'hours' => 'Jam', 'minutes' => 'Menit', 'seconds' => 'Detik'] as $unit => $lbl)
                                            <div class="text-center">
                                                <div class="text-xl font-black text-slate-900" x-text="pad({{ $unit }})">00</div>
                                                <div class="text-[9px] font-bold text-slate-400 uppercase">{{ $lbl }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="bg-slate-900 text-white font-black py-4 px-8 rounded-xl hover:bg-slate-800 transition">DAFTAR</button>
                                
                                @elseif($isLive)
                                    <a href="{{ $session->url }}" class="bg-white text-[#0e71eb] font-black py-4 px-10 rounded-xl shadow-xl hover:bg-blue-50 transition uppercase tracking-wide text-lg border-2 border-white">
                                        JOIN MEETING
                                    </a>
                                
                                @elseif($hasRecording)
                                    <a href="{{ $session->recording_url }}" class="flex items-center gap-2 font-black text-slate-500 hover:text-blue-600 transition">
                                        REKAMAN <x-heroicon-m-play-circle class="w-8 h-8" />
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
</div>

@once
<script>
function countdown(targetMs, isPast) {
    return {
        days: 0, hours: 0, minutes: 0, seconds: 0,
        start() { if (!isPast) { setInterval(() => {
            let d = Math.max(0, Math.floor((targetMs - Date.now()) / 1000));
            this.days = Math.floor(d / 86400); d %= 86400;
            this.hours = Math.floor(d / 3600); d %= 3600;
            this.minutes = Math.floor(d / 60); this.seconds = d % 60;
        }, 1000); } },
        pad(n) { return String(n).padStart(2, '0'); }
    }
}
</script>
@endonce