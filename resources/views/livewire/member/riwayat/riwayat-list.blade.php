<div class="p-6">

    <div class="flex items-end justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                Riwayat Pembelian
            </h2>

            <p class="text-sm text-slate-500">
                Semua transaksi yang pernah dilakukan.
            </p>
        </div>

        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
            {{ $purchases->total() }} Transaksi
        </span>
    </div>

    <div class="space-y-2">

        @forelse($purchases as $order)

            @php
                if ($order->items->isNotEmpty()) {
                    $items = $order->items;
                } else {
                    $items = collect(json_decode($order->cart_snapshot, true) ?? []);
                }
            @endphp

            @foreach($items as $item)

                <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 hover:bg-slate-50 hover:border-slate-300 transition">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                        {{ (is_array($item) ? $item['type'] : $item->type) === 'program'
                            ? 'bg-indigo-50'
                            : 'bg-emerald-50' }}">

                        @if((is_array($item) ? $item['type'] : $item->type) === 'program')
                            <x-heroicon-o-academic-cap class="h-5 w-5 text-indigo-600" />
                        @else
                            <x-heroicon-o-cube class="h-5 w-5 text-emerald-600" />
                        @endif

                    </div>

                    <div class="flex-1 min-w-0">

                        @php
                            $type = is_array($item)
                                ? ($item['type'] ?? 'product')
                                : ($item->type ?? 'product');
                        @endphp

                        <div class="flex items-center gap-2">

                            <p class="truncate text-sm font-semibold text-slate-900">
                                {{ is_array($item) ? $item['name'] : $item->name }}
                            </p>

                             <span
                                class="shrink-0 inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold
                                {{ $type === 'program'
                                    ? 'bg-indigo-100 text-indigo-700'
                                    : 'bg-emerald-100 text-emerald-700' }}">
                                {{ ucfirst($type) }}
                            </span>

                        </div>

                        <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                            <span>#{{ $order->order_id }}</span>

                            <span>•</span>

                            <span>{{ $order->created_at->format('d M Y') }}</span>

                            <span>•</span>

                            <span>{{ $order->created_at->format('H:i') }}</span>
                        </div>

                    </div>
                    
                    <div class="text-right shrink-0">

                        <p class="text-sm font-semibold text-slate-900">
                            Rp {{ number_format(is_array($item) ? $item['price'] : $item->price, 0, ',', '.') }}
                        </p>

                        <span
                            class="mt-1 inline-flex rounded-full px-2.5 py-0.5 text-[11px] font-semibold
                            {{ $order->status === 'paid'
                                ? 'bg-emerald-100 text-emerald-700'
                                : ($order->status === 'failed'
                                    ? 'bg-red-100 text-red-700'
                                    : 'bg-amber-100 text-amber-700') }}">
                            {{ ucfirst($order->status) }}
                        </span>

                    </div>

                </div>

            @endforeach

        @empty

            <div class="rounded-xl border border-dashed border-slate-300 py-12 text-center">

                <x-heroicon-o-shopping-bag class="mx-auto mb-3 h-10 w-10 text-slate-300" />

                <p class="font-medium text-slate-500">
                    Belum ada riwayat pembelian.
                </p>

            </div>

        @endforelse

    </div>

    @if($purchases->hasPages())
        <div class="mt-6">
            {{ $purchases->links() }}
        </div>
    @endif

</div>