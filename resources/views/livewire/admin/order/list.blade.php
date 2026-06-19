<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Riwayat Transaksi</h2>

    <div class="mb-4">
        <input 
            type="text" 
            wire:model.live="search" 
            placeholder="Cari ID Order atau Nama Customer..." 
            class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 outline-none"
        >
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-100">
                <tr>
                    <th class="p-4">ID Order</th>
                    <th class="p-4">Customer</th>
                    <th class="p-4">Whatsapp</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Payment Meth</th>
                    <th class="p-4">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="border-t">
                    <td class="p-4">{{ $order->order_id }}</td>
                    <td class="p-4">{{ $order->customer_name }}</td>
                    <td class="p-4">{{ $order->customer_whatsapp }}</td>
                    <td class="p-4">Rp {{ number_format($order->amount) }}</td>
                    <td class="p-4">{{ $order->payment_method }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded {{ $order->status == 'success' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $orders->links() }}</div>
    </div>
</div>