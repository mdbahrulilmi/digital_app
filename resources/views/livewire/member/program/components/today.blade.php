<div class="space-y-6">
    @foreach($schedules as $schedule)
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            {{-- HEADER TANGGAL --}}
            <div class="px-6 py-4 bg-slate-50 border-b">
                <h3 class="font-bold text-slate-900">{{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}</h3>
            </div>

            {{-- 1. MATERI --}}
            <div class="p-6 border-b">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-4">Materi</h4>
                <div class="space-y-3">
                    @foreach($schedule->materials as $product)
                        <div class="flex items-center justify-between bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 cursor-pointer hover:border-indigo-200" wire:click="openProduct({{ $product->id }})">
                            <p class="text-sm font-bold text-slate-900">{{ $product->title }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- 2. TUGAS --}}
            <div class="p-6 border-b">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-4">Tugas</h4>
                <div class="space-y-3">
                    @forelse($schedule->tasks as $task)
                        <div class="flex items-center justify-between bg-amber-50 border border-amber-100 rounded-2xl px-5 py-4">
                            <p class="text-sm font-bold text-amber-900">{{ $task->title }}</p>
                            <button wire:click="openUploadModal({{ $task->id }})" class="px-4 py-2 bg-amber-600 text-white text-xs font-bold rounded-xl">Kumpul</button>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic">Tidak ada tugas.</p>
                    @endforelse
                </div>
            </div>

            {{-- 3. JOURNAL (FORM) --}}
            <div class="p-6">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-4">Jurnal Harian</h4>
                
                <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-5">
                    <textarea 
                        wire:model="journalContent" 
                        class="w-full bg-white border border-emerald-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none mb-3" 
                        rows="3" 
                        placeholder="Tuliskan apa yang kamu pelajari hari ini..."></textarea>
                    
                    <div class="flex justify-end">
                        <button 
                            {{-- wire:click="saveJournal({{ $schedule->id }})" --}}
                            class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition-all"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>Simpan Jurnal</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                    </div>
                </div>

                {{-- Pesan Sukses --}}
                @if (session()->has('message'))
                    <p class="text-emerald-600 text-xs mt-2 font-bold">{{ session('message') }}</p>
                @endif
            </div>
        </div>
    @endforeach
</div>