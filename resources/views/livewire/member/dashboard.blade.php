<div class="mx-auto max-w-7xl p-6 lg:p-8 space-y-8">

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

                @if($programUtama)

                <div class="mt-8 max-w-lg">

                    <div class="flex justify-between mb-2 text-sm">

                        <span class="font-semibold">
                            Progress Belajar
                        </span>

                        <span class="font-bold">
                            {{ round($progresPersen) }}%
                        </span>

                    </div>

                    <div class="w-full h-3 rounded-full bg-white/20 overflow-hidden">

                        <div
                            class="h-full rounded-full bg-emerald-400 transition-all duration-700"
                            style="width: {{ $progresPersen }}%">
                        </div>

                    </div>

                    <p class="text-sm text-indigo-200 mt-3">
                        Tetap semangat, sedikit lagi program ini selesai 🚀
                    </p>

                </div>

                @endif

            </div>

            <div class="lg:w-80">

                <div class="rounded-3xl bg-white/10 backdrop-blur-xl border border-white/10 p-6">

                    <div class="text-sm uppercase tracking-widest text-indigo-200">

                        Program Aktif

                    </div>

                    @if($programUtama)

                        <h3 class="text-2xl font-bold mt-2">

                            {{ $programUtama->title }}

                        </h3>

                        <p class="mt-2 text-indigo-100 text-sm">

                            Lanjutkan sesi belajarmu agar progres tetap meningkat.

                        </p>

                        <a
                            href="{{ url('member/program/'.$programUtama->slug) }}"
                            class="mt-6 inline-flex items-center justify-center w-full rounded-2xl bg-white text-indigo-700 py-3 font-bold hover:scale-[1.02] transition">

                            ▶ Lanjutkan Belajar

                        </a>

                    @else

                        <div class="mt-5 text-indigo-100">

                            Belum ada program aktif.

                        </div>

                        <button
                            disabled
                            class="mt-6 w-full rounded-2xl bg-white/20 py-3">

                            Belum Ada Program

                        </button>

                    @endif

                </div>

            </div>

        </div>

    </section>





    {{-- ================= QUICK STATS ================= --}}

    <section class="grid grid-cols-2 lg:grid-cols-4 gap-5">

        <div class="rounded-3xl bg-white p-6 shadow-sm hover:shadow-xl transition">

            <div class="text-4xl">
                🔥
            </div>

            <p class="mt-5 text-xs uppercase tracking-widest text-slate-500">
                Streak
            </p>

            <h3 class="text-3xl font-black mt-1">
                {{ $stats['streak'] }}
            </h3>

            <p class="text-slate-500 text-sm">
                Hari Berturut
            </p>

        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm hover:shadow-xl transition">

            <div class="text-4xl">
                📚
            </div>

            <p class="mt-5 text-xs uppercase tracking-widest text-slate-500">

                Total Program

            </p>

            <h3 class="text-3xl font-black mt-1">

                {{ $stats['total_program'] }}

            </h3>

            <p class="text-slate-500 text-sm">

                Program Dimiliki

            </p>

        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm hover:shadow-xl transition">

            <div class="text-4xl">
                🎓
            </div>

            <p class="mt-5 text-xs uppercase tracking-widest text-slate-500">

                Program Selesai

            </p>

            <h3 class="text-3xl font-black mt-1">

                {{ $stats['program_selesai'] }}

            </h3>

            <p class="text-slate-500 text-sm">

                Sertifikat Didapat

            </p>

        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm hover:shadow-xl transition">

            <div class="text-4xl">
                🛒
            </div>

            <p class="mt-5 text-xs uppercase tracking-widest text-slate-500">

                Produk

            </p>

            <h3 class="text-3xl font-black mt-1">

                {{ $stats['total_produk'] }}

            </h3>

            <p class="text-slate-500 text-sm">

                Produk Dimiliki

            </p>

        </div>

    </section>

{{-- ================= PROGRAM REKOMENDASI ================= --}}
@if($programs->isNotEmpty())

<section class="space-y-6">

    <div class="flex items-center justify-between">

        <div>

            <h2 class="text-2xl font-black text-slate-900">
                ⭐ Program Rekomendasi
            </h2>

            <p class="text-slate-500 mt-1">
                Dipilih khusus berdasarkan aktivitas belajarmu.
            </p>

        </div>

    </div>

    @php
        $rekomendasi = $programs->first();
    @endphp

    @if($rekomendasi)

    <div class="overflow-hidden rounded-3xl bg-white border border-slate-200 shadow-lg hover:shadow-2xl transition-all duration-300">

        <div class="grid lg:grid-cols-2">

            {{-- IMAGE --}}
            <div class="relative">

                <img
                    src="{{ $rekomendasi->image }}"
                    class="h-full min-h-[420px] w-full object-cover">

                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                <span
                    class="absolute top-6 left-6 bg-amber-400 text-slate-900 px-4 py-2 rounded-full text-xs font-bold">

                    ⭐ Program Rekomendasi

                </span>

            </div>

            {{-- CONTENT --}}
            <div class="flex flex-col justify-center p-10 lg:p-12">

                <p class="text-indigo-600 font-bold uppercase tracking-[3px] text-xs">
                    Jangan Sampai Ketinggalan
                </p>

                <h2 class="mt-3 text-4xl font-black text-slate-900 leading-tight">
                    {{ $rekomendasi->title }}
                </h2>

                <p class="mt-6 text-slate-600 leading-8">
                    {{ $rekomendasi->description }}
                </p>

                {{-- INFO --}}
                <div class="mt-8 border-t border-slate-200 pt-6">

                    <dl class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-widest text-slate-400">
                                Tanggal Mulai
                            </dt>
                            <dd class="mt-2 text-base font-bold text-slate-900">
                                {{ \Carbon\Carbon::parse($rekomendasi->start_date)->translatedFormat('d F Y') }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-widest text-slate-400">
                                Tanggal Berakhir
                            </dt>
                            <dd class="mt-2 text-base font-bold text-slate-900">
                                {{ \Carbon\Carbon::parse($rekomendasi->end_date)->translatedFormat('d F Y') }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-widest text-slate-400">
                                Metode Belajar
                            </dt>
                            <dd class="mt-2 text-base font-bold text-slate-900">
                                Online
                            </dd>
                        </div>

                    </dl>

                </div>

                <a
                    href="{{ url($rekomendasi->slug) }}"
                    class="mt-10 inline-flex w-fit items-center gap-3 rounded-2xl bg-indigo-600 px-8 py-4 text-white font-bold hover:bg-indigo-700 hover:scale-[1.02] transition">

                    Daftar Sekarang

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5l7 7-7 7"/>

                    </svg>

                </a>

            </div>

        </div>

    </div>

    @endif

</section>

@endif

{{-- ================= PRODUK PREMIUM ================= --}}
@if($products->isNotEmpty())

<section class="space-y-8">

    <div class="flex items-center justify-between">

        <div>

            <h2 class="text-2xl font-black text-slate-900">
                🛒 Produk Rekomendasi
            </h2>

            <p class="text-slate-500 mt-1">
                Pilihan terbaik untuk menunjang proses belajarmu.
            </p>

        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-7">

        @foreach($products as $prod)

        <div
            class="group bg-white rounded-3xl overflow-hidden border border-slate-200 hover:border-orange-300 hover:shadow-2xl transition-all duration-300">

            {{-- IMAGE --}}
            <div class="relative overflow-hidden">

                <img
                    src="{{ $prod->image }}"
                    class="h-60 w-full object-cover duration-500 group-hover:scale-110">

                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent"></div>

            </div>

            {{-- CONTENT --}}
            <div class="p-6">

                <h3 class="font-black text-xl text-slate-900 line-clamp-2">

                    {{ $prod->title }}

                </h3>

                <p class="mt-3 text-sm text-slate-500 line-clamp-3">

                    {{ $prod->description }}

                </p>

                <div class="mt-8 flex justify-between items-center">

                    <div>

                        <p class="text-xs uppercase text-slate-400">

                            Digital Product

                        </p>

                        <p class="font-bold text-orange-600">

                            {{ ucfirst($prod->type) }}

                        </p>

                    </div>

                    <a
                        href="{{ route('public.product.show',$prod->slug) }}"
                        wire:navigate
                        class="rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-bold px-6 py-3 transition">

                        Lihat Produk

                    </a>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</section>

@endif