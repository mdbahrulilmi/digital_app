<div class="p-6 space-y-4">
    @forelse($journalsLog as $journal)
        <div class="w-full flex gap-3 group">
            <div class="flex-none flex flex-col items-center pt-2">
                <div class="flex flex-col items-center justify-center w-9 h-9 rounded-full bg-white border border-indigo-100 text-indigo-700 shadow-sm">
                    <span class="text-[9px] font-black leading-none uppercase">{{ $journal->created_at->format('M') }}</span>
                    <span class="text-[10px] font-bold">{{ $journal->created_at->format('d') }}</span>
                </div>
                <div class="w-px h-full bg-indigo-100 mt-2 group-last:hidden"></div>
            </div>
            <div class="flex-1 bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-4 border-b border-slate-100">
                    <p class="text-[13px] text-slate-800 leading-snug">
                        <span class="font-bold text-slate-400 text-[9px] uppercase tracking-wider block mb-1">Jurnal:</span>
                        {{ $journal->entry }}
                    </p>
                    
                    @if($journal->comment)
                        <div class="mt-3 p-3 bg-indigo-50/60 rounded-xl border border-indigo-100">
                            <span class="font-black text-indigo-600 text-[8px] uppercase block mb-0.5">Komentar Jurnal:</span>
                            <p class="text-[12px] text-indigo-900">{{ $journal->comment }}</p>
                        </div>
                    @endif
                </div>
                @if($journal->submission)
                    <div class="bg-slate-50 p-4 flex flex-col gap-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-black text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded uppercase">Tugas Selesai</span>
                            <button wire:click="openTaskDetail({{ $journal->submission->id }})" class="text-[10px] font-bold text-indigo-600 hover:underline uppercase">Detail</button>
                        </div>
                        
                        @if($journal->submission->comment)
                            <div class="p-3 bg-white rounded-lg border border-slate-200">
                                <span class="font-black text-slate-400 text-[8px] uppercase block mb-0.5">Feedback Mentor:</span>
                                <p class="text-[12px] text-slate-600">{{ $journal->submission->comment }}</p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="px-4 py-3 bg-slate-50/50">
                        <p class="text-[10px] text-slate-400 italic">Tidak ada pengumpulan tugas.</p>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-10 border-2 border-dashed border-slate-200 rounded-2xl text-slate-400 text-sm">Belum ada data.</div>
    @endforelse

    @if($showTaskModal && $selectedSubmission)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-black text-slate-900">Detail Tugas Dikirim</h2>
                    <button wire:click="closeTaskModal" class="text-slate-400 hover:text-slate-900">✕</button>
                </div>

                <div class="space-y-4">
                    <div class="w-full bg-slate-50 rounded-2xl overflow-hidden border border-slate-100">
                        @php
                            $path = $selectedSubmission->file_path;
                            $extension = pathinfo($path, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <img src="{{ asset('storage/' . $path) }}" class="w-full max-h-[60vh] object-contain rounded-2xl" alt="Tugas">
                        
                        @elseif($extension === 'pdf')
                            <iframe src="{{ asset('storage/' . $path) }}" class="w-full h-[60vh]" frameborder="0"></iframe>
                        
                        @else
                            <div class="p-8 text-center">
                                <p class="text-sm text-slate-500">Pratinjau tidak tersedia untuk format .{{ $extension }}</p>
                                <a href="{{ asset('storage/' . $path) }}" target="_blank" class="mt-2 block text-indigo-600 font-bold underline">Download File</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>