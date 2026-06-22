<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-slate-900">Riwayat Pembelian</h2>
        <span class="text-xs font-medium text-slate-400">{{ $purchases->count() }} Transaksi</span>
    </div>

    <div class="space-y-3">
        @forelse($purchases as $order)
            @foreach($order->items as $item)
                <div class="group flex items-center gap-4 p-4 bg-white border border-slate-100 rounded-2xl shadow-sm hover:border-indigo-100 hover:shadow-md transition-all duration-300">
                    
                    <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center shrink-0">
                        <x-heroicon-o-shopping-bag class="w-6 h-6 text-slate-400 group-hover:text-indigo-500 transition-colors" />
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-[14px] font-semibold text-slate-900 truncate pr-2">
                            {{ $item->name }} {{-- Ambil nama produk dari order_item --}}
                        </p>
                        <p class="text-[11px] text-slate-400 font-medium">
                            {{ $order->created_at->format('d M Y') }} • {{ $order->order_id }}
                        </p>
                    </div>

                    <div class="text-right shrink-0">
                        <p class="text-sm font-bold text-slate-900">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </p>
                        <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded-full mt-1 
                            {{ $order->status === 'paid' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            @endforeach
        @empty
            <div class="text-center py-10 text-slate-400">
                Belum ada riwayat pembelian.
            </div>
        @endforelse
    </div>
</div>