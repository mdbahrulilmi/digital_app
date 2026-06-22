<div class="min-h-screen bg-slate-50 flex items-center justify-center p-4">
    <div class="w-full max-w-sm bg-white p-8 rounded-3xl border border-slate-100 shadow-xl text-center">
        {{-- Ikon Sukses --}}
        <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center border border-emerald-100 mx-auto mb-6 shadow-inner">
            <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        {{-- Teks --}}
        <h2 class="text-2xl font-black text-slate-800 mb-2">Pembayaran Berhasil!</h2>
        <p class="text-sm text-slate-400 mb-8">
            Selamat, akses Anda telah aktif. Silakan mulai petualangan belajar Anda sekarang.
        </p>

        {{-- Tombol Dashboard --}}
        <a href="{{ route('member.dashboard') }}" 
           class="w-full inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg shadow-indigo-200">
            Masuk ke Dashboard
        </a>

        {{-- Opsional: Info Tambahan --}}
        <div class="mt-6">
            <p class="text-[10px] text-slate-300 uppercase tracking-widest">Akses Instan Tersedia</p>
        </div>
    </div>
</div>