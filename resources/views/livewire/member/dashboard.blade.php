<div class="p-2 space-y-8">

    <section class="relative overflow-hidden rounded-lg bg-gradient-to-br from-indigo-700 via-indigo-800 to-slate-900 p-8 lg:p-10 text-white shadow-2xl">

        <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute -bottom-40 left-0 w-96 h-96 rounded-full bg-cyan-400/10 blur-3xl"></div>

        <div class="relative z-10 flex flex-col lg:flex-row justify-between items-center gap-10">

            <div class="flex-1">

                <p class="uppercase tracking-[4px] text-xs font-bold text-indigo-200">
                    MEMBER DASHBOARD
                </p>

                <h1 class="mt-3 text-4xl lg:text-5xl font-black">
                    Halo,
                    {{ Auth::guard('member')->user()->name }} 👋
                </h1>

                <p class="mt-4 text-indigo-100 max-w-xl leading-7">
                    Selamat datang. Mulai perjalanan belajarmu sekarang.
                </p>

            </div>

            <div class="text-center lg:text-right">

                <p class="text-indigo-200 uppercase tracking-[3px] text-xs font-bold">
                    {{ now()->translatedFormat('l') }}
                </p>

                <h2
                    id="clock"
                    class="mt-2 text-5xl lg:text-6xl font-black tracking-tight">
                    00:00:00
                </h2>

                <p class="mt-2 text-indigo-100">
                    {{ now()->translatedFormat('d F Y') }}
                </p>

            </div>

        </div>

    </section>

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

                @php
                    $today = now()->startOfDay();
                    $start = \Carbon\Carbon::parse($program->start_date)->startOfDay();
                    $end = \Carbon\Carbon::parse($program->end_date)->startOfDay();
                @endphp

                <div class="flex flex-col lg:flex-row w-full bg-white rounded-xl shadow-xl overflow-hidden border border-slate-100">

                    <div class="relative w-full lg:w-1/3 h-56 lg:h-auto overflow-hidden">

                        <img
                            src="{{ $program->image }}"
                            class="absolute inset-0 w-full h-full object-cover">

                        <div class="absolute inset-0 bg-indigo-950/80 p-5 lg:p-6 flex flex-col justify-between">

                            <div>

                                <p class="text-[10px] font-bold uppercase tracking-widest text-indigo-200">
                                    Kelas
                                </p>

                                <h2 class="text-xl lg:text-lg font-bold text-white leading-tight mt-1">
                                    {{ $program->title }}
                                </h2>

                            </div>

                            <span class="w-fit px-3 py-1 rounded-full text-[10px] uppercase font-bold bg-blue-500 text-white">
                                Sedang Berjalan
                            </span>

                        </div>

                    </div>

                    <div class="flex-1 p-5 lg:p-6 flex flex-col justify-between">

                        <div>

                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">

                                <div>

                                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
                                        Program
                                    </p>

                                    <h3 class="text-xl lg:text-2xl font-bold text-slate-800">
                                        {{ $program->title }}
                                    </h3>

                                </div>

                                <div class="text-left sm:text-right">

                                    <p class="text-[10px] uppercase text-slate-400 font-bold">
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

                            <p class="text-sm text-slate-500 mt-3 line-clamp-2">
                                {{ $program->description }}
                            </p>

                            <div class="mt-4 flex flex-col sm:flex-row gap-2 sm:gap-6 text-xs text-slate-500 font-semibold">

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

                        <div class="mt-6 flex justify-stretch sm:justify-end">

                            <a
                                href="{{ route('member.program.hari-ini', $program->slug) }}"
                                class="flex w-full sm:w-auto justify-center items-center bg-blue-600 text-white px-6 py-3 rounded-full text-sm font-bold hover:bg-blue-700 transition shadow-lg">

                                Lanjutkan Belajar

                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div class="rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 py-16 text-center">

                    <p class="text-slate-400">
                        Belum ada program aktif.
                    </p>

                </div>

            @endforelse

        </div>
    </section>

    @if($showPasswordModal)
        <div class="fixed inset-0 z-[50] h-dvh w-screen bg-black/60 backdrop-blur-sm">

            <div class="flex min-h-full items-center justify-center p-4">

                <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">

                    <h2 class="text-xl font-bold text-slate-900">
                        Keamanan Akun
                    </h2>

                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        Password Anda saat ini masih menggunakan
                        <strong>Nomor WhatsApp</strong>.
                        Demi keamanan akun, kami sangat menyarankan Anda
                        untuk menggantinya sekarang.
                    </p>

                    <form wire:submit.prevent="updatePassword" class="mt-6 space-y-4">

                        <div>

                            <input
                                type="password"
                                wire:model="newPassword"
                                placeholder="Masukkan password baru"
                                class="w-full rounded-xl border border-slate-300 p-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">

                            @error('newPassword')
                                <p class="mt-1 text-xs text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <div class="flex flex-col gap-3">

                            <button
                                type="submit"
                                class="w-full rounded-xl bg-blue-600 py-3 font-semibold text-white transition hover:bg-blue-700 cursor-pointer">

                                Ubah Password

                            </button>

                            <button
                                type="button"
                                wire:click="closeModal"
                                class="w-full rounded-xl bg-slate-100 py-3 font-semibold text-slate-700 transition hover:bg-slate-200 cursor-pointer">

                                Tetap Pakai Password Lama

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    @endif

    
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        function updateClock() {
            const now = new Date();

            const time = now.toLocaleTimeString('id-ID', {
                hour12: false
            });

            document.getElementById('clock').textContent = time;
        }

        updateClock();
        setInterval(updateClock, 1000);

    });
    </script>
</div>