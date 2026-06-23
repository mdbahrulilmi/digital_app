<div class="p-6">
    @foreach(['live' => 'Segera Berlangsung', 'upcoming' => 'Akan Datang', 'past' => 'Selesai'] as $status => $label)
        
        @if(isset($sessions[$status]))
            <div>
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4 mt-4">{{ $label }}</h3>
                <div class="space-y-4">
                    @foreach($sessions[$status] as $session)
                        <div class="flex items-center gap-6 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm 
                            {{ $status === 'past' ? 'opacity-75 grayscale' : '' }}">
                            
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center shrink-0 
                                {{ $status === 'live' ? 'bg-indigo-50 text-indigo-600' : ($status === 'upcoming' ? 'bg-slate-100 text-slate-600' : 'bg-emerald-50 text-emerald-600') }}">
                                <x-heroicon-o-video-camera class="w-8 h-8" />
                            </div>

                            <div class="flex-1">
                                <h4 class="text-lg font-bold text-slate-900">{{ $session->title }}</h4>
                                <p class="text-sm text-slate-500 mt-1 flex items-center gap-4">
                                    <span class="flex items-center gap-1"><x-heroicon-o-calendar class="w-3.5 h-3.5"/> {{ \Carbon\Carbon::parse($session->date)->translatedFormat('d F Y') }}</span>
                                    <span class="flex items-center gap-1"><x-heroicon-o-clock class="w-3.5 h-3.5"/> {{ substr($session->start_time, 0, 5) }} WIB</span>
                                </p>
                            </div>

                            <div class="shrink-0">
                                @php
                                    $sessionDate = \Carbon\Carbon::parse($session->date);
                                    $today = \Carbon\Carbon::today();
                                    $isHMinusOne = $today->copy()->addDay()->isSameDay($sessionDate);
                                    $isPast = $sessionDate->isPast();
                                @endphp

                                @if($status === 'live' || $isHMinusOne)
                                    <a href="{{ $session->url }}" target="_blank" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all">
                                        {{ $status === 'live' ? 'Join Now' : 'Akses Zoom' }}
                                    </a>
                                @elseif($isPast && !empty($session->recording_url))
                                    <a href="{{ $session->recording_url }}" target="_blank" class="px-6 py-3 border border-slate-200 text-slate-600 rounded-xl font-bold hover:bg-slate-50">
                                        Lihat Rekaman
                                    </a>
                                @else
                                    <button class="px-6 py-3 bg-slate-100 text-slate-400 rounded-xl font-bold cursor-not-allowed">
                                        Belum Tersedia
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
</div>