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
                            $isCompact = !$isLive && !$isSoon   ;
                            $hasRecording = !empty($session->recording_url);
                            $targetMs = \Carbon\Carbon::parse($session->date . ' ' . $session->start_time)->timestamp * 1000;
                        @endphp

                        <div x-data="countdown({{ $targetMs }}, {{ $isPast ? 'true' : 'false' }})" x-init="start()"
                            class="relative overflow-hidden rounded-2xl flex flex-col md:flex-row items-center border shadow-sm transition-all
                            {{ $isLive ? 'p-8 bg-[#0e71eb] text-white shadow-2xl border-[#0e71eb] gap-8' : 
                                ($isSoon ? 'p-8 bg-orange-400/80 border-orange-200 text-slate-900 gap-8 text-white' : 
                                'p-5 bg-white border-slate-200 text-slate-900 gap-6') }}">

                            {{-- Ornamen untuk Live --}}
                            @if($isLive)
                                <div class="absolute -top-12 -right-12 w-48 h-48 bg-white opacity-20 rounded-full blur-3xl"></div>
                            @endif

                            {{-- Icon --}}
                            <div class="rounded-2xl flex items-center justify-center shrink-0 z-10 
                                {{ $isLive ? 'w-20 h-20 bg-white text-[#0e71eb]' : 
                                ($isSoon ? 'w-20 h-20 bg-white text-orange-600' : 
                                'w-14 h-14 bg-slate-100 text-slate-400') }}">
                                <x-heroicon-o-video-camera class="{{ $isCompact ? 'w-7 h-7' : 'w-10 h-10' }}" />
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 w-full z-10">
                                @if($isLive)
                                    <div class="px-3 py-1 bg-white text-[#0e71eb] text-[10px] font-black rounded-full uppercase animate-pulse inline-block mb-3">LIVE NOW</div>
                                @elseif($isSoon)
                                    <div class="px-3 py-1 bg-orange-500 text-white text-[10px] font-black rounded-full uppercase animate-pulse inline-block mb-3 tracking-widest">SEGERA HADIR</div>
                                @endif
                                
                                {{-- Container Flex: Judul dan Tanggal --}}
                                <div class="flex {{ $isCompact ? 'flex-col md:flex-row md:items-center md:justify-between' : 'flex-col' }} gap-2">
                                    
                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                                        <h4 class="{{ $isCompact ? 'text-lg' : 'text-2xl' }} font-black leading-tight">
                                            {{ $session->title }}
                                        </h4>
                                        
                                        @if($hasRecording)
                                            <a href="{{ $session->recording_url }}" class="flex items-center gap-1 font-bold text-sm text-blue-500 hover:text-blue-600 shrink-0">
                                                <x-heroicon-m-play-circle class="w-6 h-6" /> Rekaman
                                            </a>
                                        @endif
                                    </div>
                                    
                                    <div class="inline-flex gap-2 items-center rounded-lg {{ ($isLive || $isSoon) ? 'text-white' : 'bg-slate-100 text-slate-700 px-3 py-1.5' }} shrink-0">
                                        <x-heroicon-o-calendar-days class="w-4 h-4 opacity-70" />
                                        
                                        <span class="font-black {{ $isCompact ? 'text-[10px]' : 'text-xs' }} tracking-widest uppercase">
                                            {{ \Carbon\Carbon::parse($session->date)->translatedFormat('d F Y') }}
                                        </span>
                                        
                                        <span class="opacity-30">|</span>
                                        
                                        <span class="font-black {{ $isCompact ? 'text-[10px]' : 'text-xs' }}">
                                            {{ substr($session->start_time, 0, 5) }} - {{ substr($session->end_time, 0, 5) }} WIB
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Sisi Kanan --}}
                            <div class="flex items-center gap-6 shrink-0 z-10">
                                @if($isSoon)
                                    <div class="flex gap-4">
                                        @foreach(['days' => 'Hari', 'hours' => 'Jam', 'minutes' => 'Menit', 'seconds' => 'Detik'] as $unit => $lbl)
                                            <div class="text-center">
                                                <div class="text-xl font-black text-white" x-text="pad({{ $unit }})">00</div>
                                                <div class="text-[9px] font-bold text-white uppercase">{{ $lbl }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <a href="{{ $session->url }}" class="bg-white text-orange-600 font-black py-4 px-8 rounded-xl shadow-md hover:bg-orange-50 active:scale-95 transition-all cursor-pointer">
                                        DAFTAR SEKARANG
                                    </a>
                                
                                @elseif($isLive)
                                    <a href="{{ $session->url }}" class="bg-white text-[#0e71eb] font-black py-4 px-10 rounded-xl shadow-xl uppercase tracking-wide text-lg hover:bg-blue-100 active:scale-95 transition-all">JOIN MEETING</a>
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