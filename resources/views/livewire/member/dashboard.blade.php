    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-100 border-b border-gray-200">
            <tr>
                <th class="p-4 font-semibold text-gray-700">Order ID</th>
                <th class="p-4 font-semibold text-gray-700">Name</th>
                <th class="p-4 font-semibold text-gray-700">Total</th>
                <th class="p-4 font-semibold text-gray-700">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-mono text-sm text-blue-600">{{ $order->order_id }}</td>
                    <td class="p-4">
                        @php $items = $order->items @endphp
                        @foreach($items as $item)
                            {{ $item['name'] }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                    <td class="p-4">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                    <td class="p-4">
                        <span class="px-3 py-1 text-xs font-bold rounded-full uppercase
                            {{ $order->status === 'success' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $order->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500">Belum ada riwayat pesanan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>