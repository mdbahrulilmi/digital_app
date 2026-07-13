<div class="p-2">

    <h2 class="text-3xl font-extrabold text-slate-900 mb-8 tracking-tight">
        Program Eksklusif Anda
    </h2>

    @php
        $groups = [
            [
                'title' => '🚀 Sedang Berjalan',
                'programs' => $activePrograms,
                'empty' => 'Tidak ada program yang sedang berjalan.'
            ],
            [
                'title' => '📅 Akan Datang',
                'programs' => $upcomingPrograms,
                'empty' => 'Tidak ada program yang akan datang.'
            ],
            [
                'title' => '✅ Selesai',
                'programs' => $finishedPrograms,
                'empty' => 'Belum ada program yang selesai.'
            ]
        ];
    @endphp

    @foreach($groups as $group)

        <div class="mb-10">

            <h3 class="text-xl font-bold text-slate-800 mb-4">
                {{ $group['title'] }}
            </h3>

            <div class="space-y-3">

                @forelse($group['programs'] as $program)

                    @php
                        $today = now()->startOfDay();
                        $start = \Carbon\Carbon::parse($program->start_date)->startOfDay();
                        $end = \Carbon\Carbon::parse($program->end_date)->startOfDay();

                        if ($today->lt($start)) {
                            $badge = 'Akan Datang';
                            $badgeClass = 'bg-amber-500';
                            $statusText = 'Mulai dalam '.$today->diffInDays($start).' hari';
                        } elseif ($today->lte($end)) {
                            $badge = 'Sedang Berjalan';
                            $badgeClass = 'bg-blue-500';
                            $statusText = 'Selesai dalam '.$today->diffInDays($end).' hari';
                        } else {
                            $badge = 'Selesai';
                            $badgeClass = 'bg-slate-500';
                            $statusText = 'Program selesai';
                        }
                    @endphp

                    <div class="flex w-full rounded-xl overflow-hidden h-[180px]
                        {{ $badge == 'Sedang Berjalan'
                            ? 'bg-gradient-to-r from-blue-50 to-white border-2 border-blue-400 shadow-[0_0_35px_rgba(59,130,246,0.35)]'
                            : ($badge == 'Akan Datang'
                                ? 'bg-amber-50 border border-amber-200 shadow-lg'
                                : 'bg-slate-50 border border-slate-200 opacity-80 shadow') }}">

                        {{-- IMAGE --}}
                        <div class="relative w-1/3 overflow-hidden">

                            <img
                                src="{{ $program->image }}"
                                class="absolute inset-0 w-full h-full object-cover">

                            <div class="absolute inset-0 bg-indigo-950/80 p-6 flex flex-col justify-between">

                                @if($badge == 'Sedang Berjalan')
                                    <div class="absolute top-3 right-3 z-20">
                                        <span class="flex items-center gap-2 bg-blue-500 text-white px-3 py-1 rounded-full shadow-lg">

                                            <span class="relative flex h-2.5 w-2.5">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                                <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-white"></span>
                                            </span>

                                            <span class="text-[10px] font-bold uppercase">
                                                Aktif
                                            </span>

                                        </span>
                                    </div>
                                @endif

                                <div>

                                    <p class="text-[10px] font-bold uppercase tracking-widest text-indigo-200">
                                        Kelas
                                    </p>

                                    <h2 class="text-lg font-bold text-white leading-tight">
                                        {{ $program->title }}
                                    </h2>

                                </div>

                                <span class="w-fit px-3 py-1 rounded-full text-[10px] font-bold uppercase text-white {{ $badgeClass }}">
                                    {{ $badge }}
                                </span>

                            </div>

                        </div>

                        {{-- CONTENT --}}
                        <div class="px-6 py-5 flex flex-col justify-between flex-1">

                            <div>

                                <div class="flex justify-between items-start">

                                    <div>

                                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
                                            Program
                                        </p>

                                        <h3 class="text-xl font-bold text-slate-800">
                                            {{ $program->title }}
                                        </h3>

                                    </div>

                                    <div class="text-right">

                                        <p class="text-[10px] uppercase text-slate-400 font-bold">
                                            Status
                                        </p>

                                        <p class="text-sm font-black text-indigo-950">
                                            {{ $statusText }}
                                        </p>

                                    </div>

                                </div>

                                <p class="text-xs text-slate-500 mt-2 line-clamp-2">
                                    {{ $program->description }}
                                </p>

                                <div class="flex gap-5 mt-3 text-[11px] text-slate-400 font-semibold">

                                    <span>
                                        📅 Mulai:
                                        {{ $start->format('d M Y') }}
                                    </span>

                                    <span>
                                        🏁 Selesai:
                                        {{ $end->format('d M Y') }}
                                    </span>

                                </div>

                            </div>

                            <div class="flex justify-end">

                                @if($today->lt($start))

                                    <span class="bg-amber-500 text-white px-6 py-2 rounded-full text-xs font-bold">
                                        Belum Dimulai
                                    </span>

                                @elseif($today->lte($end))

                                    <a
                                        href="{{ route('member.program.hari-ini', $program->slug) }}"
                                        class="bg-blue-600 text-white px-6 py-2 rounded-full text-xs font-bold hover:bg-blue-700 transition shadow-lg">
                                        Lanjutkan Belajar
                                    </a>

                                @else

                                    <a
                                        {{-- href="{{ route('member.certificate.show', $program->slug) }}" --}}
                                        class="bg-emerald-600 text-white px-6 py-2 rounded-full text-xs font-bold hover:bg-emerald-700 transition shadow-lg cursor-pointer">
                                        Cetak Sertifikat
                                    </a>

                                @endif

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 py-8 text-center text-slate-400">
                        {{ $group['empty'] }}
                    </div>

                @endforelse

            </div>

        </div>

    @endforeach

</div>