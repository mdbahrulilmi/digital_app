<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Program Saya</h2>

    <div class="space-y-4">
        @forelse($orderItems as $item)
            <div class="flex items-center justify-between bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover:shadow-md transition-shadow">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $item->name }}</h3>
                    <p class="text-sm text-gray-500">
                        Order ID: <span class="font-mono">{{ $item->order_id }}</span>
                    </p>
                    <span class="inline-block mt-2 px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $item->order->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($item->order->status) }}
                    </span>
                </div>
                
                <div>
                    <a href="{{ route('member.program.hari-ini', $item->program->slug ?? '#') }}" 
                       class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                        Mulai
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-gray-500">
                Belum ada program yang aktif atau dipesan.
            </div>
        @endforelse
    </div>
</div>