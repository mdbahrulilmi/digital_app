<div class="w-full max-w-md min-h-screen bg-slate-50 flex flex-col mx-auto p-4 font-sans text-slate-800">

    @if (session()->has('error'))
        <div class="bg-rose-50 border border-rose-100 text-rose-600 text-xs p-2.5 rounded-xl font-medium mb-3">{{ session('error') }}</div>
    @endif

    @if($paymentStatus !== 'success' && $paymentStatus !== 'settlement')
        <div wire:poll.3s="checkPaymentStatus" class="hidden"></div>
    @endif

    <div
        x-data="{ copied: false, toast: false, copyCode(code) {
            navigator.clipboard.writeText(code);
            this.copied = true; this.toast = true;
            setTimeout(() => this.copied = false, 2000);
            setTimeout(() => this.toast = false, 2500);
        } }"
        class="relative"
    >
        <div
            x-show="toast"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-4 left-1/2 -translate-x-1/2 z-50 bg-slate-900 text-white text-xs font-semibold px-4 py-2.5 rounded-full shadow-lg flex items-center gap-2"
            style="display:none;"
        >
            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
            </svg>
            Kode berhasil disalin
        </div>

        <div
            x-data="countdown({{ $expiredAt }})"
            x-init="start()"
            class="flex justify-between items-center px-1 pb-3"
        >
            <span class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center">
                    @if(in_array($method, ['dana', 'shopeepay']))
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h16a2 2 0 002-2V7a2 2 0 00-2-2H3a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    @elseif($qrUrl)
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM17 14h.01M14 17h3v3h-3z"/></svg>
                    @else
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/></svg>
                    @endif
                </span>
                <span class="text-xs font-semibold text-slate-700 uppercase">
                    @if($qrUrl) QRIS @else Virtual Account {{ strtoupper(str_replace('va_', '', $method)) }} @endif
                </span>
            </span>
            @if(!in_array($paymentStatus, ['success','settlement','expire','expired','cancel','cancelled']))
                <span class="flex items-center gap-1 text-xs font-bold text-red-500">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span x-text="time"></span>
                </span>
            @endif
        </div>

        @if($paymentStatus === 'success' || $paymentStatus === 'settlement')
            <div class="bg-white rounded-2xl p-8 text-center space-y-3">
                <div class="w-14 h-14 mx-auto bg-emerald-50 rounded-full flex items-center justify-center border border-emerald-100">
                    <svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-black text-slate-800">Pembayaran Berhasil!</h3>
                <p class="text-xs text-slate-400">Terima kasih, pesanan Anda sedang kami proses.</p>
            </div>

        @elseif(in_array($paymentStatus, ['expire', 'expired', 'cancel', 'cancelled']))
            <div class="bg-white rounded-2xl p-8 text-center space-y-3">
                <div class="w-14 h-14 mx-auto bg-rose-50 rounded-full flex items-center justify-center border border-rose-100">
                    <svg class="w-7 h-7 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-black text-slate-800">Pembayaran Gagal/Kadaluwarsa</h3>
                <p class="text-xs text-slate-400">Silakan lakukan pemesanan ulang.</p>
            </div>

        @else
            <div class="bg-white rounded-2xl p-6 text-center mb-3 shadow-sm">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Total Pembayaran</p>
                <p class="text-4xl font-black text-indigo-600 mt-1">Rp {{ number_format($amount, 0, ',', '.') }}</p>
                <span class="inline-flex items-center gap-1.5 mt-3 bg-amber-50 text-amber-700 text-[11px] font-bold px-3 py-1 rounded-full">
                    <span class="flex h-1.5 w-1.5 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-amber-500"></span>
                    </span>
                    Menunggu Pembayaran
                </span>
            </div>

            <div class="bg-white rounded-2xl p-6 text-center shadow-sm border-2 border-indigo-100 mb-3">

                @if(in_array($method, ['dana', 'shopeepay']) && $eWalletUrl)
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-4">
                        Bayar via <span class="text-indigo-600">{{ strtoupper($method) }}</span>
                    </p>
                    <a href="{{ $eWalletUrl }}" target="_blank" rel="noopener noreferrer"
                       class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl transition text-sm">
                        Bayar Sekarang
                    </a>

                @elseif($qrUrl)
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">Scan QRIS</p>
                    <img src="{{ $qrUrl }}" alt="QRIS Code" class="w-52 h-52 mx-auto border p-2 rounded-xl">
                    <a href="{{ $qrUrl }}" download="qris-{{ $orderId }}.png" target="_blank"
                       class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-4 py-2 rounded-lg transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v12m0 0l-4-4m4 4l4-4M4 20h16"/>
                        </svg>
                        Download QR
                    </a>

                @elseif($paymentCode)
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">
                        Virtual Account <span class="text-indigo-600">{{ strtoupper($method) }}</span>
                    </p>
                    <p class="text-3xl font-black tracking-widest text-slate-800 my-3 break-all">
                        {{ $paymentCode }}
                    </p>
                    <button
                        @click="copyCode('{{ $paymentCode }}')"
                        class="inline-flex items-center gap-1.5 text-sm font-bold px-4 py-2.5 rounded-lg transition w-full justify-center"
                        :class="copied ? 'text-emerald-700 bg-emerald-50' : 'text-white bg-indigo-600 hover:bg-indigo-700'"
                    >
                        <template x-if="!copied">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </template>
                        <template x-if="copied">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </template>
                        <span x-text="copied ? 'Kode Tersalin!' : 'Salin Kode Pembayaran'"></span>
                    </button>
                @endif
            </div>

            <div x-data="{ open: true }" class="bg-white rounded-2xl shadow-sm mb-3 overflow-hidden">
                <button @click="open = !open" class="w-full flex items-center justify-between p-4 text-left">
                    <span class="flex items-center gap-2 text-sm font-bold text-slate-700">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Cara Pembayaran
                    </span>
                    <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="px-4 pb-4 space-y-2.5">
                    @if($qrUrl)
                        <div class="flex gap-2.5 text-xs text-slate-500"><span class="flex-none w-4 h-4 rounded-full bg-slate-100 text-slate-500 font-bold text-[10px] flex items-center justify-center">1</span>Buka aplikasi e-wallet atau m-banking Anda</div>
                        <div class="flex gap-2.5 text-xs text-slate-500"><span class="flex-none w-4 h-4 rounded-full bg-slate-100 text-slate-500 font-bold text-[10px] flex items-center justify-center">2</span>Pilih menu Scan QR / Bayar</div>
                        <div class="flex gap-2.5 text-xs text-slate-500"><span class="flex-none w-4 h-4 rounded-full bg-slate-100 text-slate-500 font-bold text-[10px] flex items-center justify-center">3</span>Arahkan kamera ke kode QR di atas</div>
                        <div class="flex gap-2.5 text-xs text-slate-500"><span class="flex-none w-4 h-4 rounded-full bg-slate-100 text-slate-500 font-bold text-[10px] flex items-center justify-center">4</span>Periksa nominal lalu selesaikan pembayaran</div>
                    @elseif($paymentCode)
                        <div class="flex gap-2.5 text-xs text-slate-500"><span class="flex-none w-4 h-4 rounded-full bg-slate-100 text-slate-500 font-bold text-[10px] flex items-center justify-center">1</span>Buka aplikasi m-banking atau kunjungi ATM {{ strtoupper($method) }}</div>
                        <div class="flex gap-2.5 text-xs text-slate-500"><span class="flex-none w-4 h-4 rounded-full bg-slate-100 text-slate-500 font-bold text-[10px] flex items-center justify-center">2</span>Pilih menu Transfer &rarr; Virtual Account</div>
                        <div class="flex gap-2.5 text-xs text-slate-500"><span class="flex-none w-4 h-4 rounded-full bg-slate-100 text-slate-500 font-bold text-[10px] flex items-center justify-center">3</span>Masukkan nomor VA di atas</div>
                        <div class="flex gap-2.5 text-xs text-slate-500"><span class="flex-none w-4 h-4 rounded-full bg-slate-100 text-slate-500 font-bold text-[10px] flex items-center justify-center">4</span>Periksa nominal, lalu konfirmasi pembayaran</div>
                    @endif
                </div>
            </div>
        @endif

        <div class="flex justify-between items-center px-1 text-[11px] text-slate-400">
            <span>Order <strong class="text-slate-500">{{ $orderId }}</strong></span>
            <span class="flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Status diperbarui otomatis
            </span>
        </div>
    </div>

    @if($showExpiredModal)
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => { history.go(-2); }, 5000)"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-6"
        >
            <div x-transition.scale class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="p-8 text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <h2 class="mt-4 text-xl font-bold text-slate-800">Pembayaran Kedaluwarsa</h2>
                    <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                        Waktu pembayaran telah habis sehingga pesanan otomatis dibatalkan.
                        Silakan lakukan pemesanan kembali untuk mendapatkan invoice baru.
                    </p>
                </div>
                <div class="h-1 bg-slate-100">
                    <div class="h-full bg-red-500" x-init="$el.animate([{width:'100%'},{width:'0%'}],{duration:5000,fill:'forwards'})"></div>
                </div>
            </div>
        </div>
    @endif

    <script>
    function countdown(expiredTimestamp) {
        return {
            time: '03:00',
            expiredSent: false,
            timer: null,

            start() {
                this.update();
                this.timer = setInterval(() => {
                    this.update();
                }, 1000);
            },

            update() {
                let now = Math.floor(Date.now() / 1000);
                let diff = expiredTimestamp - now;

                if (diff <= 0) {
                    this.time = '00:00';

                    if (!this.expiredSent) {
                        this.expiredSent = true;
                        clearInterval(this.timer);

                        Livewire.dispatch('payment-expired');
                    }

                    return;
                }

                let minutes = Math.floor(diff / 60);
                let seconds = diff % 60;

                this.time = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
            }
        }
    }
    </script>
</div>