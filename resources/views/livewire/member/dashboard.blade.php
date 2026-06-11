<div class="w-full max-w-4xl mx-auto p-6 font-sans text-slate-800">
    {{-- Header Dashboard --}}
    <div class="flex justify-between items-center mb-8 bg-gradient-to-r from-indigo-600 to-violet-600 p-6 rounded-2xl text-white shadow-md">
        <div>
            <h1 class="text-2xl font-black">Dashboard Member Area</h1>
            <p class="text-sm opacity-90 mt-1">Selamat datang kembali, <span class="font-bold">{{ auth()->guard('member')->user()->name }}</span>!</p>
        </div>
        <div>
            {{-- Tombol Logout --}}
            <button onclick="document.getElementById('logout-form').submit();" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-xl text-xs font-bold transition">
                Keluar Aplikasi
            </button>
            <form id="logout-form" action="/member/logout" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>

    {{-- Notifikasi Jika Pembayaran Baru Saja Sukses --}}
    @if(session()->has('message'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl text-sm font-medium">
            {{ session('message') }}
        </div>
    @endif

    <h2 class="text-lg font-bold text-slate-700 mb-4">Riwayat Pembelian Produk</h2>

    {{-- List Pesanan --}}
    <div class="space-y-4">
        @forelse($orders as $order)
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm space-y-4">
                
                {{-- Bagian Atas / Header Kartu Pesanan --}}
                <div class="flex justify-between items-start pb-3 border-b border-slate-100 text-xs">
                    <div>
                        <p class="font-black text-slate-700 text-sm">{{ $order->order_id }}</p>
                        <p class="text-slate-400 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                    
                    {{-- Status Badge Medali Pembayaran --}}
                    <div>
                        @if($order->status === 'success' || $order->status === 'settlement')
                            <span class="bg-emerald-50 text-emerald-600 font-bold px-3 py-1.5 rounded-lg text-xs">Sukses (Lunas)</span>
                        @elseif($order->status === 'pending')
                            <span class="bg-amber-50 text-amber-600 font-bold px-3 py-1.5 rounded-lg text-xs">Menunggu Pembayaran</span>
                        @else
                            <span class="bg-rose-50 text-rose-600 font-bold px-3 py-1.5 rounded-lg text-xs uppercase">{{ $order->status }}</span>
                        @endif
                    </div>
                </div>

                {{-- LOOPING KEDUA: Menampilkan Banyak Produk di Dalam 1 Order ini --}}
                <div class="divide-y divide-slate-50">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-center py-3 first:pt-0 last:pb-0">
                            <div class="flex-1 min-w-0 pr-4">
                                <p class="font-semibold text-slate-800 text-sm truncate">{{ $item->product_name }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">Jumlah: {{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-medium text-slate-600">
                                    Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Bagian Bawah Kartu / Total Pembayaran --}}
                <div class="pt-3 border-t border-slate-100 flex justify-between items-center">
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Metode Pembayaran:</span>
                        <span class="text-xs font-bold text-slate-600 uppercase">{{ $order->payment_method }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-slate-400 font-medium block">Total Pembayaran:</span>
                        <span class="text-base font-black text-indigo-600">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Tombol Tindakan Tambahan jika Masih Pending --}}
                @if($order->status === 'pending')
                    <div class="pt-2">
                        <a href="/payment/invoice?order_id={{ $order->order_id }}&method={{ $order->payment_method }}" class="block text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-bold text-xs py-2.5 rounded-xl transition shadow-sm">
                            Lihat Cara Instruksi Pembayaran
                        </a>
                    </div>
                @endif

            </div>
        @empty
            {{-- Tampilan Jika Member Belum Pernah Punya Riwayat Transaksi Sukses --}}
            <div class="bg-white border border-dashed border-slate-200 rounded-2xl text-center py-12 text-slate-400 text-sm">
                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Belum ada produk yang dibeli atau terverifikasi.
            </div>
        @endforelse
    </div>
</div>