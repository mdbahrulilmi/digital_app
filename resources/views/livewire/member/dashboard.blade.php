<div class="p-2 space-y-8">

    {{-- ================= HERO ================= --}}
    <section class="relative overflow-hidden rounded-lg bg-gradient-to-br from-indigo-700 via-indigo-800 to-slate-900 p-8 lg:p-10 text-white shadow-2xl">

        <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute -bottom-40 left-0 w-96 h-96 rounded-full bg-cyan-400/10 blur-3xl"></div>

        <div class="relative z-10 flex flex-col lg:flex-row justify-between gap-10">

            <div class="flex-1">

                <p class="uppercase tracking-[4px] text-xs font-bold text-indigo-200">
                    MEMBER DASHBOARD
                </p>

                <h1 class="mt-3 text-4xl lg:text-5xl font-black">
                    Halo,
                    {{ Auth::guard('member')->user()->name }}
                    👋
                </h1>

                <p class="mt-4 text-indigo-100 max-w-xl leading-7">

                    @if($programUtama)

                        Kamu sedang mengikuti
                        <strong>{{ $programUtama->title }}</strong>.
                        Yuk lanjutkan belajarmu hari ini.

                    @else

                        Selamat datang.
                        Mulai perjalanan belajarmu sekarang.

                    @endif

                </p>
            </div>

        </div>

    </section>





    {{-- ================= QUICK STATS ================= --}}

    <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">

    <div class="rounded-lg bg-white p-4 shadow-sm hover:shadow-lg transition">

        <div class="text-3xl">🔥</div>

        <p class="mt-3 text-[11px] uppercase tracking-wider text-slate-500">
            Streak
        </p>

        <h3 class="mt-1 text-2xl font-black">
            {{ $stats['streak'] }}
        </h3>

        <p class="text-xs text-slate-500">
            Hari Berturut
        </p>

    </div>

    <div class="rounded-lg bg-white p-4 shadow-sm hover:shadow-lg transition">

        <div class="text-3xl">📚</div>

        <p class="mt-3 text-[11px] uppercase tracking-wider text-slate-500">
            Total Program
        </p>

        <h3 class="mt-1 text-2xl font-black">
            {{ $stats['total_program'] }}
        </h3>

        <p class="text-xs text-slate-500">
            Program Dimiliki
        </p>

    </div>

    <div class="rounded-lg bg-white p-4 shadow-sm hover:shadow-lg transition">

        <div class="text-3xl">🎓</div>

        <p class="mt-3 text-[11px] uppercase tracking-wider text-slate-500">
            Program Selesai
        </p>

        <h3 class="mt-1 text-2xl font-black">
            {{ $stats['program_selesai'] }}
        </h3>

        <p class="text-xs text-slate-500">
            Sertifikat Didapat
        </p>

    </div>

    <div class="rounded-lg bg-white p-4 shadow-sm hover:shadow-lg transition">

        <div class="text-3xl">🛒</div>

        <p class="mt-3 text-[11px] uppercase tracking-wider text-slate-500">
            Produk
        </p>

        <h3 class="mt-1 text-2xl font-black">
            {{ $stats['total_produk'] }}
        </h3>

        <p class="text-xs text-slate-500">
            Produk Dimiliki
        </p>

    </div>

</section>
    <section class="space-y-6">
        <div class="flex items-end justify-between">
            <div>
                <h2 class="text-3xl font-black text-slate-900">📚 Program Saya</h2>
                <p class="text-slate-500 mt-1">Daftar kursus eksklusif yang sedang Anda pelajari.</p>
            </div>
            <a href="{{ route('member.program.list') }}" class="text-indigo-600 font-bold hover:underline">Lihat Semua →</a>
        </div>

        <div class="space-y-3">
            @forelse($memberPrograms as $program)
                <div class="flex w-full bg-white rounded-lg shadow-xl overflow-hidden h-[180px] border border-slate-100">

                    <div class="relative w-1/3 overflow-hidden">

                        <img 
                            src="{{ $program->image }}" 
                            class="absolute inset-0 w-full h-full object-cover">

                        <div class="absolute inset-0 bg-indigo-950/80 p-6 flex flex-col justify-between">

                            <div>

                                <p class="text-[10px] font-bold uppercase tracking-widest text-indigo-200">
                                    Kelas
                                </p>

                                <h2 class="text-lg font-bold text-white leading-tight">
                                    {{ $program->title }}
                                </h2>

                            </div>


                            <span class="w-fit px-2 py-1 rounded-full text-[9px] uppercase font-bold
                                {{ $program->status == 'active' ? 'bg-green-500 text-white' : 'bg-slate-500 text-white' }}">
                                Sedang Berjalan
                            </span>

                        </div>

                    </div>

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


                                @php
                                    $today = now()->startOfDay();
                                    $start = \Carbon\Carbon::parse($program->start_date)->startOfDay();
                                    $end = \Carbon\Carbon::parse($program->end_date)->startOfDay();
                                @endphp

                                <div class="text-right">

                                    <p class="text-[10px] text-slate-400 uppercase font-bold">
                                        Status
                                    </p>

                                    <p class="text-sm font-black text-indigo-950">
                                        @if($today->lt($start))
                                            Mulai dalam {{ $today->diffInDays($start) }} hari
                                        @elseif($today->lte($end))
                                            Selesai dalam {{ $today->diffInDays($end) }} hari
                                        @else
                                            Program selesai
                                        @endif
                                    </p>

                                </div>

                            </div>


                            <p class="text-xs text-slate-500 mt-2 line-clamp-2">
                                {{ $program->description }}
                            </p>


                            <div class="flex gap-4 mt-3 text-[11px] text-slate-400 font-semibold">

                                <span>
                                    Mulai:
                                    {{ \Carbon\Carbon::parse($program->start_date)->format('d M Y') }}
                                </span>

                                <span>
                                    Selesai:
                                    {{ \Carbon\Carbon::parse($program->end_date)->format('d M Y') }}
                                </span>

                            </div>


                        </div>


                        <div class="flex justify-end">

                            <a href="{{ route('member.program.hari-ini', $program->slug) }}" 
                            class="bg-emerald-600 text-white px-6 py-2 rounded-full text-xs font-bold hover:bg-emerald-700 transition shadow-lg">

                                Lanjutkan Belajar

                            </a>

                        </div>


                    </div>

                </div>
            @empty
                <div class="text-center py-16 bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200">
                    <p class="text-slate-400">Belum ada program aktif.</p>
                </div>
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