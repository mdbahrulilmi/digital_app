<div class="p-4 md:p-6 space-y-12">
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-emerald-100 text-emerald-800 rounded-2xl text-sm font-bold">
            {{ session('message') }}
        </div>
    @endif
    @forelse($schedules as $day)
        @php $isToday = \Carbon\Carbon::parse($day->date)->isToday(); @endphp

        <div class="group relative bg-white border border-slate-200 shadow-[0_20px_50px_-12px_rgba(0,0,0,0.05)] overflow-hidden">
            
            {{-- HEADER: Diubah jadi terang (Light Theme) --}}
            <div class="{{ $isToday ? 'bg-indigo-50 border-b border-indigo-100' : 'bg-slate-50 border-b border-slate-100' }} px-8 py-8">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.25em] {{ $isToday ? 'text-indigo-600' : 'text-slate-500' }} mb-1">
                            {{ \Carbon\Carbon::parse($day->date)->translatedFormat('l, d F Y') }}
                        </p>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                            Agenda Harian
                        </h2>
                    </div>
                    
                    @if($isToday)
                        <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100/50 border border-indigo-200 text-indigo-700 text-[10px] font-bold uppercase tracking-widest">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                            </span>
                            Live Now
                        </div>
                    @endif
                </div>
            </div>

            <div class="p-8 space-y-8 bg-white">
                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Materi --}}
                    <div class="p-6 rounded-3xl border border-slate-100 bg-slate-50">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Materi
                        </h3>
                        <div class="space-y-3">
                            @foreach($day->materials as $i => $product)
                                <div 
                                wire:click="openProduct({{ $product->id }})"
                                class="cursor-pointer flex items-center justify-between p-3 rounded-2xl bg-white border border-slate-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center text-[10px] font-bold">
                                            {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <span class="text-xs font-bold text-slate-700">{{ $product->title }}</span>
                                    </div>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Tugas --}}
                    <div class="p-6 rounded-3xl border border-slate-100 bg-slate-50">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Tugas
                        </h3>
                        
                        @if($day->tasks->isNotEmpty())
                            <div class="space-y-3 mb-4">
                                @foreach($day->tasks as $task)
                                    @php 
                                        $sub = $submissions->get($task->id); 
                                    @endphp
                                    
                                    <div class="p-3 rounded-2xl bg-white border border-amber-100">
                                        <span class="text-xs font-bold text-slate-700 block mb-1">{{ $task->title }}</span>
                                        
                                        @if($sub)
                                            <div class="mt-2 pt-2 border-t border-slate-50">
                                                <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-wider">
                                                    ✅ Jawaban diupload: {{ \Carbon\Carbon::parse($sub->created_at)->translatedFormat('d M Y, H:i') }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            @php
                                $hasSubmitted = $submissions->has($day->schedules_id);
                            @endphp

                            <button wire:click="openUploadModal({{ $day->schedules_id }})" 
                                class="cursor-pointer w-full py-3 {{ $hasSubmitted ? 'bg-emerald-600' : 'bg-slate-900' }} text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:opacity-90 transition-all">
                                {{ $hasSubmitted ? 'Ubah Jawaban' : 'Kumpulkan' }}
                            </button>
                        @else
                            <div class="text-slate-400 text-xs italic text-center py-6">Tidak ada tugas.</div>
                        @endif
                    </div>
                </div>

               {{-- Jurnal --}}
                <div class="p-6 rounded-3xl border border-slate-100 bg-slate-50">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> 
                        {{-- Logika: Cek apakah data untuk schedule hari ini ada di array journalContents --}}
                        {{ isset($journalContents[$day->schedules_id]) ? 'Edit Catatan Refleksi' : 'Catatan Refleksi Baru' }}
                    </h3>
                    
                    <textarea 
                        wire:model="journalContents.{{ $day->schedules_id }}" 
                        class="w-full bg-white border-slate-200 rounded-2xl p-4 text-sm text-slate-700 focus:ring-2 focus:ring-emerald-400 transition-all resize-none min-h-[80px]" 
                        placeholder="Apa insight kamu hari ini?">
                    </textarea>

                    <div class="flex justify-end">
                        <button wire:click="saveJournal({{ $day->schedules_id }})" 
                            class="mt-4 px-8 py-3 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-600 transition-all">
                            {{ isset($journalContents[$day->schedules_id]) ? 'Update Catatan' : 'Simpan Catatan' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-20 text-slate-400">Hari ini cukup isi journal</div>
        <div class="p-8 bg-white border border-slate-200 rounded-3xl shadow-sm">
        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-3">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> 
            Catatan Refleksi Hari Ini
        </h3>
        
        <textarea 
            wire:model="journalContents.today" 
            class="w-full bg-slate-50 border-slate-200 rounded-2xl p-4 text-sm text-slate-700 focus:ring-2 focus:ring-emerald-400 transition-all resize-none min-h-[100px]" 
            placeholder="Apa insight kamu hari ini?"></textarea>

        <div class="flex justify-end">
            <button wire:click="saveJournal" 
                class="mt-4 px-8 py-3 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-600 transition-all">
                {{ isset($journalContents['today']) ? 'Update Catatan' : 'Simpan Catatan' }}
            </button>
        </div>
    </div>
    @endforelse

    @include('livewire.member.program.components.modals.today-modal')
</div>