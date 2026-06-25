<div class="p-6 max-w-7xl mx-auto">
    <div class="flex items-end justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Materi Program</h2>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        
        @forelse($products as $product)
        <div class="group flex flex-col bg-white rounded-2xl border border-slate-200 hover:border-indigo-200 shadow-sm hover:shadow-xl hover:shadow-indigo-500/10 transition-all duration-300 overflow-hidden">
            <div class="relative h-40 w-full overflow-hidden shrink-0">
                <img src="{{ $product->image }}" 
                     alt="{{ $product->title }}" 
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            </div>

            <div class="p-5 flex flex-col flex-grow">
                <div class="h-12 mb-4">
                    <h3 class="text-sm font-bold text-slate-800 leading-snug group-hover:text-indigo-600 transition-colors line-clamp-2">
                        {{ $product->title }}
                    </h3>
                </div>
                <button type="button" 
                        wire:click="openProduct({{ $product->id }})" 
                        class="w-full py-2.5 border border-slate-900 text-slate-900 text-sm font-bold rounded-lg hover:bg-slate-900 hover:text-white transition-all duration-300">
                    Lihat Materi
                </button>
            </div>
        </div>
        @empty
            <div class="col-span-full text-center py-20 text-slate-400">
                <p>Belum ada materi yang tersedia.</p>
            </div>
        @endforelse
    </div>
    
    @include('livewire.member.program.components.modals.today-modal')
</div>