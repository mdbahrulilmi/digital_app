@php
    $zoomSessions = [
        ['title' => 'Live Mentoring: Fullstack Deployment', 'status' => 'live', 'date' => '22 Juni 2026', 'time' => '19:00 WIB'],
        ['title' => 'Diskusi Panel: Future of AI', 'status' => 'upcoming', 'date' => '28 Juni 2026', 'time' => '14:00 WIB'],
        ['title' => 'Review Tugas Mingguan #1', 'status' => 'past', 'date' => '15 Juni 2026', 'time' => '10:00 WIB'],
    ];
@endphp

<div class="p-6">

    @foreach(['live' => 'Segera Berlangsung', 'upcoming' => 'Akan Datang', 'past' => 'Selesai'] as $status => $label)
        
        {{-- Filter hanya sesi dengan status tersebut --}}
        @php $filtered = array_filter($zoomSessions, fn($s) => $s['status'] === $status); @endphp
        
        @if(count($filtered) > 0)
            <div>
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4 mt-4">{{ $label }}</h3>
                <div class="space-y-4">
                    @foreach($filtered as $session)
                        <div class="flex items-center gap-6 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm 
                            {{ $status === 'past' ? 'opacity-75 grayscale' : '' }}">
                            
                            {{-- Icon Status --}}
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center shrink-0 
                                {{ $status === 'live' ? 'bg-indigo-50 text-indigo-600' : ($status === 'upcoming' ? 'bg-slate-100 text-slate-600' : 'bg-emerald-50 text-emerald-600') }}">
                                <x-heroicon-o-video-camera class="w-8 h-8" />
                            </div>

                            {{-- Info --}}
                            <div class="flex-1">
                                <h4 class="text-lg font-bold text-slate-900">{{ $session['title'] }}</h4>
                                <p class="text-sm text-slate-500 mt-1 flex items-center gap-4">
                                    <span class="flex items-center gap-1"><x-heroicon-o-calendar class="w-3.5 h-3.5"/> {{ $session['date'] }}</span>
                                    <span class="flex items-center gap-1"><x-heroicon-o-clock class="w-3.5 h-3.5"/> {{ $session['time'] }}</span>
                                </p>
                            </div>

                            {{-- Button --}}
                            <div class="shrink-0">
                                @if($status === 'live')
                                    <a href="#" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">Join Now</a>
                                @elseif($status === 'upcoming')
                                    <button class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold cursor-not-allowed">Belum Mulai</button>
                                @else
                                    <a href="#" class="px-6 py-3 border border-slate-200 text-slate-600 rounded-xl font-bold hover:bg-slate-50 transition-all">Lihat Rekaman</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach

</div>