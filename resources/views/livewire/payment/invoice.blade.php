<div class="w-full max-w-md min-h-screen bg-slate-50 shadow-xl flex flex-col justify-start mx-auto p-4 font-sans text-slate-800">
    <div class="text-center py-6">
        <h2 class="text-xl font-black text-slate-800">Instruksi Pembayaran</h2>
        <p class="text-xs text-slate-400 mt-1">Selesaikan pembayaran Anda agar pesanan diproses</p>
    </div>

    @if (session()->has('error'))
        <div class="bg-rose-50 border border-rose-100 text-rose-600 text-sm p-3 rounded-xl font-medium mb-4">{{ session('error') }}</div>
    @endif

    {{-- KUNCI NYA DI SINI: Jika status BELUM sukses, lakukan polling cekStatus setiap 3 detik --}}
    @if($paymentStatus !== 'success' && $paymentStatus !== 'settlement')
        <div wire:poll.3s="checkPaymentStatus" class="hidden"></div>
    @endif

    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm text-center space-y-4">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pembayaran</span>
            <h1 class="text-2xl font-black text-indigo-600 mt-0.5">Rp {{ number_format($amount, 0, ',', '.') }}</h1>
        </div>

        <div class="border-t border-slate-100 pt-3 flex justify-between text-xs font-medium text-slate-500">
            <span>Order ID: <strong>{{ $orderId }}</strong></span>
            <span>Metode: <strong class="uppercase text-indigo-600">{{ $method }}</strong></span>
        </div>

        <hr class="border-slate-100">

        {{-- KONDISI 1: JIKA SUDAH SUKSES --}}
        @if($paymentStatus === 'success' || $paymentStatus === 'settlement')
            <div class="flex flex-col items-center py-6 space-y-3">
                <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center border border-emerald-100 shadow-sm">
                    <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-black text-slate-800">Pembayaran Berhasil!</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Terima kasih, pesanan Anda sedang kami proses.</p>
                </div>
            </div>

        {{-- KONDISI 2: JIKA EXPIRED / CANCELLED --}}
        @elseif(in_array($paymentStatus, ['expire', 'expired', 'cancel', 'cancelled']))
            <div class="flex flex-col items-center py-6 space-y-3">
                <div class="w-16 h-16 bg-rose-50 rounded-full flex items-center justify-center border border-rose-100 shadow-sm">
                    <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-black text-slate-800">Pembayaran Gagal/Kadaluwarsa</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Silakan lakukan pemesanan ulang.</p>
                </div>
            </div>

        {{-- KONDISI 3: BELUM BAYAR (MENUNGGU PEMBAYARAN) --}}
        @else
            <div class="bg-amber-50 border border-amber-100 rounded-xl py-2 px-3 inline-flex items-center space-x-2 mx-auto">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                </span>
                <span class="text-xs font-bold text-amber-700 animate-pulse">Menunggu Pembayaran...</span>
            </div>

            {{-- JIKA QRIS --}}
            @if($qrUrl)
                <div class="flex flex-col items-center py-2">
                    <img src="{{ $qrUrl }}" alt="QRIS Code" class="w-56 h-56 border p-2 rounded-xl bg-white shadow-sm">
                    <p class="text-[11px] text-slate-400 mt-2">Scan kode QR di atas menggunakan aplikasi e-wallet / m-banking Anda</p>
                </div>
            @endif

            {{-- JIKA RITEL (ALFA/INDO) --}}
            @if($paymentCode && !$qrUrl)
                <div class="relative group cursor-pointer" onclick="navigator.clipboard.writeText('{{ $paymentCode }}'); alert('Kode disalin!');">
                    <span class="text-3xl font-black tracking-widest text-slate-800">{{ $paymentCode }}</span>
                    <span class="absolute -top-6 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[9px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Klik untuk salin</span>
                </div>
                <p class="text-[11px] text-slate-400">Tunjukkan kode ini ke kasir <span class="uppercase font-bold">{{ $method }}</span> saat melakukan pembayaran.</p>
            @endif
        @endif
    </div>
</div>
</div>