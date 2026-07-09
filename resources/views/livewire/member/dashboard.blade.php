<div class="p-2 space-y-8">

    {{-- ================= HERO ================= --}}
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-700 via-indigo-800 to-slate-900 p-8 lg:p-10 text-white shadow-2xl">

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

    <div class="rounded-2xl bg-white p-4 shadow-sm hover:shadow-lg transition">

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

    <div class="rounded-2xl bg-white p-4 shadow-sm hover:shadow-lg transition">

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

    <div class="rounded-2xl bg-white p-4 shadow-sm hover:shadow-lg transition">

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

    <div class="rounded-2xl bg-white p-4 shadow-sm hover:shadow-lg transition">

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

                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    📚 Program Saya
                </h2>

                <p class="mt-2 text-slate-500">
                    Lanjutkan program yang sedang kamu ikuti.
                </p>

            </div>

            @if($totalMemberPrograms > 3)

                <a
                    href="{{ route('member.program.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3 font-semibold text-slate-700 transition hover:border-indigo-500 hover:text-indigo-600">

                    Lihat Semua Program

                    <svg class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5l7 7-7 7"/>

                    </svg>

                </a>

            @endif

        </div>

        <div class="space-y-6">

            @forelse($memberPrograms as $program)

                <div class="relative overflow-hidden rounded-[2rem] p-8 shadow-2xl transition-all duration-500 hover:scale-[1.02] group">

                    {{-- Background --}}
                    <img
                        src="{{ $program->image }}"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                    {{-- Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-indigo-900/80 to-transparent"></div>

                    <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-8">

                        {{-- Left --}}
                        <div>

                            <div class="flex items-center gap-3 mb-4">

                                <span class="px-3 py-1 text-[10px] font-bold tracking-widest uppercase bg-indigo-500 text-white rounded-full">
                                    Active Member
                                </span>

                            </div>

                            <h3 class="text-3xl font-black text-white tracking-tight">
                                {{ $program->title }}
                            </h3>

                            <p class="mt-2 text-blue-100 text-sm max-w-lg leading-relaxed">
                                Teruskan perjalanan belajarmu dan capai target penyelesaian program.
                            </p>

                        </div>

                        {{-- Right --}}
                        <div class="flex-shrink-0">

                            <a
                                href="{{ route('member.program.hari-ini', $program->slug) }}"
                                class="inline-flex items-center gap-2 px-8 py-4 bg-white text-indigo-900 rounded-2xl font-bold hover:bg-slate-100 transition-all duration-300 shadow-xl active:scale-95">

                                <span>Lanjutkan Belajar</span>

                                <svg class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"/>

                                </svg>

                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div class="text-center py-20 border-2 border-dashed border-slate-200 rounded-[2rem]">

                    <p class="text-slate-400 font-medium">
                        Belum ada program yang sedang kamu ikuti.
                    </p>

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