<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-6">

        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                Riwayat Transaksi
            </h2>

            <p class="text-sm text-slate-500">
                Kelola seluruh transaksi pelanggan.
            </p>
        </div>

        <div class="flex flex-col md:flex-row gap-3">

            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari Order / Customer..."
                class="w-full md:w-72 rounded-xl border border-slate-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-indigo-500">

            <select
                wire:model.live="status"
                class="rounded-xl border border-slate-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-indigo-500">

                <option value="">Semua Status</option>
                <option value="paid">Paid</option>
                <option value="pending">Pending</option>
                <option value="failed">Failed</option>

            </select>

        </div>

    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-50">

                    <tr class="text-xs uppercase tracking-wider text-slate-500">

                        <th class="px-6 py-4 text-left">
                            Order
                        </th>

                        <th class="px-6 py-4 text-left">
                            Customer
                        </th>

                        <th class="px-6 py-4 text-left">
                            Total
                        </th>

                        <th class="px-6 py-4 text-left">
                            Payment
                        </th>

                        <th class="px-6 py-4 text-left whitespace-nowrap">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-right">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($orders as $order)

                    <tr class="hover:bg-slate-50 transition">

                        {{-- Order --}}
                        <td class="px-6 py-5">

                            <div class="font-semibold text-slate-900">
                                {{ $order->order_id }}
                            </div>

                            <div class="text-xs text-slate-500">
                                {{ $order->customer_whatsapp }}
                            </div>

                        </td>

                        {{-- Customer --}}
                        <td class="px-6 py-5">

                            <div class="font-semibold text-slate-900">
                                {{ $order->customer_name }}
                            </div>

                            <div class="text-sm text-slate-500 truncate max-w-[220px]">
                                {{ $order->customer_email }}
                            </div>

                        </td>

                        {{-- Total --}}
                        <td class="px-6 py-5 whitespace-nowrap">

                            <span class="font-bold text-slate-900">
                                Rp {{ number_format($order->amount,0,',','.') }}
                            </span>

                        </td>

                        {{-- Payment --}}
                        <td class="px-6 py-5">

                            @php

                            $paymentMethod = strtolower($order->payment_method);

                            switch (true) {

                                case str_starts_with($paymentMethod, 'va_'):
                                    $paymentColor = 'bg-blue-100 text-blue-700';
                                    $paymentLabel = strtoupper(str_replace('va_', '', $paymentMethod)) . ' VA';
                                    break;

                                case $paymentMethod === 'qris':
                                    $paymentColor = 'bg-emerald-100 text-emerald-700';
                                    $paymentLabel = 'QRIS';
                                    break;

                                case in_array($paymentMethod, ['gopay', 'shopeepay', 'ovo', 'dana', 'linkaja']):
                                    $paymentColor = 'bg-purple-100 text-purple-700';
                                    $paymentLabel = strtoupper($paymentMethod);
                                    break;

                                case in_array($paymentMethod, ['credit_card', 'cc']):
                                    $paymentColor = 'bg-orange-100 text-orange-700';
                                    $paymentLabel = 'Credit Card';
                                    break;

                                case in_array($paymentMethod, ['cstore', 'alfamart', 'indomaret']):
                                    $paymentColor = 'bg-amber-100 text-amber-700';
                                    $paymentLabel = ucfirst($paymentMethod);
                                    break;

                                default:
                                    $paymentColor = 'bg-slate-100 text-slate-700';
                                    $paymentLabel = strtoupper($paymentMethod);
                                    break;
                            }

                        @endphp

                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $paymentColor }}">

                                {{ strtoupper($order->payment_method) }}

                            </span>

                        </td>

                        {{-- Date --}}
                        <td class="px-6 py-5 whitespace-nowrap">

                            <div class="font-medium text-slate-800">
                                {{ $order->created_at->format('d M Y') }}
                            </div>

                            <div class="text-xs text-slate-500">
                                {{ $order->created_at->format('H:i') }}
                            </div>

                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-5 text-right">

                            @switch($order->status)

                                @case('paid')

                                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">

                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                                        Paid

                                    </span>

                                @break

                                @case('pending')

                                    <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">

                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>

                                        Pending

                                    </span>

                                @break

                                @case('failed')

                                    <span class="inline-flex items-center gap-2 rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700">

                                        <span class="w-2 h-2 rounded-full bg-red-500"></span>

                                        Failed

                                    </span>

                                @break

                                @default

                                    <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">

                                        {{ ucfirst($order->status) }}

                                    </span>

                            @endswitch

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="py-16 text-center">

                            <div class="text-slate-400">

                                <div class="text-5xl mb-3">
                                    📄
                                </div>

                                <p class="font-medium">
                                    Tidak ada transaksi ditemukan.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="border-t bg-slate-50 px-6 py-4">

            {{ $orders->links() }}

        </div>

    </div>

</div>