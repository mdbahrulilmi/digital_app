<!-- Background tetap di luar -->
<div class="min-h-screen bg-slate-50 p-6">
        <h2 class="text-3xl font-extrabold text-slate-900 mb-8 tracking-tight">Produk Eksklusif Anda</h2>
        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($orderItems as $item)
                <div class="bg-white border border-slate-200 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all duration-300">
                    <!-- Image -->
                    <div class="w-full aspect-video rounded-2xl overflow-hidden mb-5 bg-slate-100">
                        <img src="{{ asset($item->product->image) }}" 
                             alt="{{ $item->title }}" 
                             class="w-full h-full object-cover">
                    </div>

                    <!-- Content -->
                    <h3 class="text-base font-bold text-slate-900 mb-2 truncate">
                        {{ $item->title }}
                    </h3>
                    <p class="text-sm text-slate-500 mb-6 line-clamp-2">
                        {{ $item->product->description ?? 'Deskripsi belum tersedia.' }}
                    </p>
                    
                    <a href="{{ route('member.product.show', ['slug' => $item->product->slug]) }}" 
                       class="block w-full py-3 text-center bg-slate-900 text-white rounded-xl font-semibold text-sm hover:bg-indigo-600 transition-colors">
                        Lihat Detail
                    </a>
                </div>
            @empty
                <div class="col-span-full py-20 text-center text-slate-500">
                    <p>Belum ada produk yang tersedia.</p>
                </div>
            @endforelse
        </div>
</div>