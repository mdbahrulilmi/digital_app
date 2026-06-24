<div class="space-y-12">
    {{-- Notifikasi --}}
    @if (session()->has('message'))
        <div class="p-4 bg-emerald-50 text-emerald-800 border border-emerald-100 rounded-2xl text-sm font-bold shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    @forelse($schedules as $day)
        @php $isToday = \Carbon\Carbon::parse($day->date)->isToday(); @endphp

        <div class="group relative bg-white duration-500 overflow-hidden">
            
            <div class="{{ $isToday ? 'bg-gradient-to-r from-indigo-50 to-white' : 'bg-slate-50' }} px-6 md:px-8 py-8 border-b border-slate-100 transition-colors duration-500">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">Agenda Harian</h2>
                    </div>
                    
                    @if($isToday)
                        <div class="flex md:justify-end">
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-500 text-white text-[9px] md:text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-500/30 animate-pulse whitespace-nowrap">
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                {{ \Carbon\Carbon::parse($day->date)->translatedFormat('l, d F Y') }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="p-8 space-y-8 bg-white">
                <div class="grid md:grid-cols-2 gap-6">
                    
                    <div class="p-6 rounded-3xl border border-slate-100 bg-slate-50/50">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-400"></span> Materi
                        </h3>
                        <div class="space-y-3">
                            @forelse($day->materials as $i => $product)
                                <div wire:click="openProduct({{ $product->id }})"
                                     class="group/item cursor-pointer flex items-center justify-between p-3 rounded-2xl bg-white hover:bg-slate-900 border border-slate-100 transition-all duration-300">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover/item:bg-slate-800 text-slate-500 group-hover/item:text-slate-300 flex items-center justify-center text-[10px] font-bold transition-all">
                                            {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <span class="text-xs font-bold text-slate-700 group-hover/item:text-white transition-all">{{ $product->title }}</span>
                                    </div>
                                    <svg class="w-4 h-4 text-slate-300 group-hover/item:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            @empty
                                <p class="text-slate-400 text-xs italic text-center py-4">Tidak ada materi tersedia.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="p-6 rounded-3xl border border-amber-100 bg-amber-50/20">
                        <h3 class="text-[10px] font-black text-amber-500 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span> Tugas
                        </h3>
                        @if($day->tasks->isNotEmpty())
                            <div class="space-y-3">
                                @foreach($day->tasks as $task)
                                    @php $sub = $submissions->get($task->id); @endphp
                                    <div class="p-3 rounded-2xl bg-white border border-amber-100">
                                        <span class="text-xs font-bold text-slate-700 block mb-1">{{ $task->task }}</span>
                                        @if($sub)
                                            <p class="text-[9px] text-emerald-600 font-bold uppercase tracking-wider mt-2 pt-2 border-t border-slate-50">
                                                ✅ Selesai: {{ \Carbon\Carbon::parse($sub->created_at)->translatedFormat('d M, H:i') }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @if($day->upload_required == 1)
                                <button wire:click="openUploadModal({{ $day->schedules_id }})" wire:loading.attr="disabled"
                                    class="w-full py-3 mt-4 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-slate-800 hover:scale-[1.01] transition-all disabled:opacity-50">
                                    {{ $submissions->has($day->schedules_id) ? 'Ubah Jawaban' : 'Kumpulkan Tugas' }}
                                </button>
                            @endif
                        @else
                            <p class="text-slate-400 text-xs italic text-center py-6">Tidak ada tugas.</p>
                        @endif
                    </div>
                </div>

                <div class="p-6 rounded-3xl border border-emerald-100 bg-emerald-50/20">
                <h3 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] mb-4">Refleksi Hari Ini</h3>
                
                <textarea wire:model="journalContents.{{ $day->schedules_id }}" 
                    class="w-full bg-white border-emerald-100 rounded-2xl p-4 text-sm text-slate-700 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300 transition-all resize-none min-h-[100px]" 
                    placeholder="Apa insight kamu hari ini?"></textarea>
                
                <div class="flex justify-end">
                    <button wire:click="saveJournal({{ $day->schedules_id }})" 
                            wire:loading.attr="disabled"
                            class="cursor-pointer mt-4 px-8 py-3 bg-emerald-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-700 hover:shadow-lg hover:shadow-emerald-500/20 transition-all disabled:opacity-50">
                        {{ isset($journalContents[$day->schedules_id]) ? 'Update Catatan' : 'Simpan Catatan' }}
                    </button>
                </div>
            </div>
            </div>
        </div>
    @empty
        <div class="text-center py-20 text-slate-400 font-medium">Belum ada agenda tersedia.</div>
    @endforelse

    @include('livewire.member.program.components.modals.today-modal')
</div>