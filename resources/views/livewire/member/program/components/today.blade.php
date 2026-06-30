<div class="space-y-12">
    {{-- Notification Component --}}
    <div x-data="{ show: false, message: '' }" 
        x-on:show-notification.window="message = $event.detail.message; show = true; setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="fixed top-5 right-5 z-50 p-4 bg-emerald-50 text-emerald-800 border border-emerald-100 rounded-2xl text-sm font-bold shadow-lg"
        style="display: none;">
        <span x-text="message"></span>
    </div>

    @forelse($schedules as $day)
        @php 
            $isToday = \Carbon\Carbon::parse($day->date)->isToday(); 
            $hasMaterials = $day->materials->isNotEmpty();
        @endphp

        <div class="group relative bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden transition-all duration-500">
            {{-- Header --}}
            <div class="{{ $isToday ? 'bg-gradient-to-r from-indigo-50 to-white' : 'bg-slate-50' }} px-8 py-6 border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Agenda Harian</h2>
                    @if($isToday)
                        <span class="px-4 py-1.5 rounded-full bg-indigo-500 text-white text-[9px] font-black uppercase tracking-widest animate-pulse">
                            {{ \Carbon\Carbon::parse($day->date)->translatedFormat('d F Y') }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-8 space-y-6">
                {{-- 1. Materi Section --}}
                <div class="rounded-3xl border {{ $hasMaterials ? 'border-blue-100 bg-blue-50/30' : 'border-slate-100 bg-slate-50' }} p-6 transition-all duration-500">
                    <h3 class="text-[10px] font-black {{ $hasMaterials ? 'text-blue-600' : 'text-slate-400' }} uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full {{ $hasMaterials ? 'bg-blue-500' : 'bg-slate-300' }}"></span> Materi
                    </h3>
                    <div class="space-y-3">
                        @forelse($day->materials as $i => $product)
                            <div wire:click="openProduct({{ $product->id }})" class="cursor-pointer flex items-center justify-between p-3 rounded-2xl bg-white border border-slate-100 hover:border-blue-200 transition-all">
                                <span class="text-xs font-bold text-slate-700">{{ $product->title }}</span>
                                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        @empty
                            <p class="text-slate-400 text-xs italic text-center py-2">Tidak ada materi hari ini.</p>
                        @endforelse
                    </div>
                </div>

                {{-- 2. Tugas Section --}}
                <div class="rounded-3xl border border-amber-100 bg-amber-50/20 p-6">
                    <h3 class="text-[10px] font-black text-amber-500 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span> Tugas
                    </h3>
                    @if($day->tasks->isNotEmpty())
                        <div class="space-y-3">
                            @foreach($day->tasks as $task)
                                <div class="p-3 rounded-2xl bg-white border border-amber-100 text-xs font-bold text-slate-700">{{ $task->task }}</div>
                            @endforeach
                            @if($day->upload_required == 1)
                                <button wire:click="openUploadModal({{ $day->schedules_id }})" class="w-full py-3 bg-slate-900 text-white text-[10px] font-black uppercase rounded-xl hover:bg-slate-800 transition-all">
                                    {{ $submissions->has($day->schedules_id) ? 'Ubah Jawaban' : 'Kumpulkan Tugas' }}
                                </button>
                            @endif
                        </div>
                    @else
                        <p class="text-slate-400 text-xs italic text-center">Tidak ada tugas.</p>
                    @endif
                </div>

                {{-- 3. Refleksi Section (Highlight jika materi kosong) --}}
                <div class="rounded-3xl border-2 {{ !$hasMaterials ? 'border-emerald-400 bg-emerald-50 shadow-lg shadow-emerald-500/10' : 'border-emerald-100 bg-emerald-50/20' }} p-6 transition-all duration-500">
                    <h3 class="text-[10px] font-black {{ !$hasMaterials ? 'text-emerald-700' : 'text-emerald-600' }} uppercase tracking-[0.2em] mb-4">
                        {{ !$hasMaterials ? '✨ Waktunya Refleksi' : 'Refleksi Hari Ini' }}
                    </h3>
                    <textarea wire:model="journalContents.{{ $day->schedules_id }}" 
                        class="w-full bg-white border-emerald-100 rounded-2xl p-4 text-sm text-slate-700 focus:ring-2 focus:ring-emerald-200 transition-all resize-none min-h-[100px]" 
                        placeholder="Apa insight kamu hari ini?"></textarea>
                    <div class="flex justify-end">
                        <button wire:click="saveJournal({{ $day->schedules_id }})" 
                            class="mt-4 px-8 py-3 {{ !$hasMaterials ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-emerald-600' }} text-white text-[10px] font-black uppercase rounded-xl transition-all">
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