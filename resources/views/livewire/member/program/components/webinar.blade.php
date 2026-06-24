<div class="p-6 md:p-12 min-h-screen bg-slate-50 relative overflow-hidden">
    <div class="fixed inset-0 overflow-hidden z-0 pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-indigo-100/50 rounded-full blur-[120px]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] bg-purple-100/50 rounded-full blur-[120px]"></div>
    </div>

    <div class="relative z-10">
        <div class="mb-12">
            <h2 class="text-4xl font-black text-slate-900 tracking-tighter">Jadwal Webinar</h2>
            <p class="text-slate-500 mt-2 font-medium">Sesi eksklusif untuk pengembangan skill Anda</p>
        </div>

        @foreach(['live' => 'Segera Berlangsung', 'upcoming' => 'Akan Datang', 'past' => 'Selesai'] as $status => $label)
            @if(isset($sessions[$status]) && count($sessions[$status]))
                <div class="mb-12">
                    <div class="flex items-center gap-4 mb-6">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ $label }}</h3>
                        <div class="h-px flex-1 bg-slate-200"></div>
                    </div>

                    <div class="grid grid-cols-1 gap-5">
                        @foreach($sessions[$status] as $session)
                            @php
                                $isPast = $status === 'past';
                                $targetDate = \Carbon\Carbon::parse($session->date . ' ' . $session->start_time)->timestamp * 1000;
                            @endphp
                            
                            <div x-data="countdown({{ $targetDate }}, {{ $isPast ? 'true' : 'false' }})" x-init="start()" 
                                 class="group relative bg-white/70 backdrop-blur-2xl border border-white p-6 rounded-3xl shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_50px_rgba(0,0,0,0.1)] transition-all duration-500 {{ $isPast ? 'opacity-60 grayscale' : '' }}">
                                
                                <div class="absolute inset-0 bg-gradient-to-br from-white/80 to-transparent rounded-3xl pointer-events-none"></div>

                                <div class="relative flex flex-col lg:flex-row items-center gap-6">
                                    
                                    <div class="flex items-center gap-6 flex-1 w-full">
                                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center shrink-0 bg-slate-900 text-white shadow-xl">
                                            <x-heroicon-o-video-camera class="w-7 h-7" />
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-bold text-slate-900 leading-tight">{{ $session->title }}</h4>
                                            <div class="text-xs text-slate-500 mt-1 flex items-center gap-4">
                                                <span class="font-semibold">{{ \Carbon\Carbon::parse($session->date)->translatedFormat('d M Y') }}</span>
                                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                                <span class="font-bold text-indigo-600">{{ substr($session->start_time, 0, 5) }} WIB</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-6 w-full lg:w-auto justify-between lg:justify-end">
                                        
                                        @if($status === 'upcoming')
                                            <div class="flex gap-3 font-black text-slate-900 text-base">
                                                <div class="text-center"><span x-text="days"></span><p class="text-[7px] text-slate-400 uppercase">Hari</p></div>
                                                <div class="text-center"><span x-text="pad(hours)"></span><p class="text-[7px] text-slate-400 uppercase">Jam</p></div>
                                                <div class="text-center"><span x-text="pad(minutes)"></span><p class="text-[7px] text-slate-400 uppercase">Menit</p></div>
                                                <div class="text-center"><span x-text="pad(seconds)"></span><p class="text-[7px] text-slate-400 uppercase">Detik</p></div>
                                            </div>
                                        @endif

                                        <div class="shrink-0">
                                            @if($session->access_status === 'zoom')
                                                <a href="{{ $session->url }}" target="_blank" class="px-8 py-4 bg-slate-900 hover:bg-indigo-600 text-white rounded-2xl font-bold text-xs transition-all shadow-lg hover:shadow-indigo-500/30 block">Join Live</a>
                                            @elseif($session->access_status === 'recording' && !empty($session->recording_url))
                                                <a href="{{ $session->recording_url }}" target="_blank" class="px-8 py-4 border border-slate-200 text-slate-600 rounded-2xl font-bold text-xs bg-white/50 hover:bg-white block">Lihat Rekaman</a>
                                            @else
                                                <button disabled class="px-8 py-4 bg-slate-100 text-slate-400 rounded-2xl font-bold text-xs cursor-not-allowed block">Belum Tersedia</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

@once
<script>
    function countdown(targetMs, isPast) {
        return {
            days: 0, hours: 0, minutes: 0, seconds: 0,
            _timer: null,
            start() { if (!isPast) { this._tick(); this._timer = setInterval(() => this._tick(), 1000); } },
            _tick() {
                let diff = Math.max(0, Math.floor((targetMs - Date.now()) / 1000));
                this.days = Math.floor(diff / 86400); diff -= this.days * 86400;
                this.hours = Math.floor(diff / 3600); diff -= this.hours * 3600;
                this.minutes = Math.floor(diff / 60);
                this.seconds = diff % 60;
            },
            pad(n) { return String(n).padStart(2, '0'); }
        }
    }
</script>
@endonce