<div class="p-6">
    <h2 class="text-3xl font-extrabold text-slate-900 mb-8 tracking-tight">Program Eksklusif Anda</h2>

    <div class="space-y-6">
        @forelse($orderItems as $item)
            {{-- Kartu Premium --}}
            <div class="relative overflow-hidden bg-white border border-slate-200 rounded-[2rem] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-500 hover:shadow-[0_20px_50px_rgb(0,0,0,0.1)] group">
                
                {{-- Decorative Element --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-indigo-50/50 to-transparent rounded-full -mr-16 -mt-16 blur-3xl transition-transform group-hover:scale-110"></div>

                <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-3 py-1 text-[10px] font-bold tracking-widest uppercase bg-slate-900 text-white rounded-full">
                                {{ $item->order->status === 'paid' ? 'Active Member' : 'Pending Access' }}
                            </span>
                            <span class="text-xs text-slate-400 font-mono">ID: {{ $item->order_id }}</span>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-slate-900 mb-2">{{ $item->name }}</h3>
                        <p class="text-slate-500 text-sm">Akses penuh ke materi eksklusif dan sesi pendampingan.</p>
                    </div>
                    
                    <div class="flex-shrink-0">
                        <a href="{{ route('member.program.hari-ini', $item->program->slug ?? '#') }}" 
                           class="inline-flex items-center gap-2 px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-indigo-600 transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/20 active:scale-95">
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