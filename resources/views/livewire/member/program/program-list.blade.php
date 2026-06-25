<div class="p-6">
    <h2 class="text-3xl font-extrabold text-slate-900 mb-8 tracking-tight">Program Eksklusif Anda</h2>
    <div class="space-y-6">
        @forelse($orderItems as $item)
            <div class="relative overflow-hidden rounded-[2rem] p-8 shadow-2xl transition-all duration-500 hover:scale-[1.02] group">
            <img src="{{ $item->program->image }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="Program Background">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-blue-900/80 to-transparent"></div>
            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-3 py-1 text-[10px] font-bold tracking-widest uppercase bg-blue-500 text-white rounded-full backdrop-blur-sm bg-opacity-80">
                            {{ $item->order->status === 'paid' ? 'Active Member' : 'Pending Access' }}
                        </span>
                    </div>
                    
                    <h3 class="text-2xl font-black text-white mb-2 tracking-tight">{{ $item->name }}</h3>
                    <p class="text-blue-100 text-sm max-w-sm leading-relaxed font-medium">Akses eksklusif materi pembelajaran dengan kurikulum terstruktur.</p>
                </div>
                
                <div class="flex-shrink-0">
                    <a href="{{ route('member.program.hari-ini', $item->program->slug ?? '#') }}" 
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-900 rounded-2xl font-bold hover:bg-blue-50 transition-all duration-300 shadow-xl active:scale-95">
                        <span>Mulai Belajar</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
        @empty
            <div class="text-center py-20 border-2 border-dashed border-slate-200 rounded-[2rem]">
                <p class="text-slate-400 font-medium">Belum ada program premium yang terdaftar.</p>
            </div>
        @endforelse
    </div>
</div>