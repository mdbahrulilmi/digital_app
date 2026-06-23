{{-- GRID PRODUK DINAMIS --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    
    @forelse($orderItems as $item)
    <div class="group flex flex-col bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden transition-all duration-500 hover:shadow-[0_20px_50px_rgb(0,0,0,0.1)] hover:-translate-y-2">
        
        {{-- Image Container --}}
        <div class="relative h-56 w-full overflow-hidden shrink-0">
            <img src="{{ asset('storage/' . $item->image) }}" 
                 alt="{{ $item->title }}" 
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        </div>

        <div class="p-8 flex flex-col flex-grow">
            {{-- Badge Kategori --}}
            <div class="mb-4">
                <span class="text-[10px] font-bold uppercase tracking-widest text-indigo-500 bg-indigo-50 px-3 py-1 rounded-full">
                    {{ $item->category->name ?? 'Kursus' }}
                </span>
            </div>

            <div class="h-12 mb-6">
                <h3 class="text-[17px] font-bold text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors line-clamp-2">
                    {{ $item->title }}
                </h3>
            </div>
            
            <div class="mt-auto pt-4 border-t border-slate-50">
                <a href="{{ route('member.product.show', ['slug' => $item->product->slug]) }}" 
                    class="flex items-center justify-center w-full py-3.5 bg-slate-900 text-white rounded-xl font-bold hover:bg-indigo-600 transition-all duration-300">
                        Lihat Produk
                </a>
            </div>
        </div>
    </div>
    @empty
        <p class="text-slate-500">Belum ada produk yang tersedia.</p>
    @endforelse

</div>