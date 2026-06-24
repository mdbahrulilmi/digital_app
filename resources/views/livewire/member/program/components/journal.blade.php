<div class="p-6 space-y-8">
    @forelse($journalsLog as $journal)
        <div class="flex gap-6 group">
            {{-- Timeline Column --}}
            <div class="flex flex-col items-center shrink-0 w-12 pt-1">
                <div class="flex flex-col items-center justify-center w-10 h-10 rounded-full bg-indigo-50 border-2 border-indigo-100 text-indigo-700">
                    <span class="text-[10px] font-black leading-none">{{ $journal->created_at->format('M') }}</span>
                    <span class="text-[11px] font-bold">{{ $journal->created_at->format('d') }}</span>
                </div>
                <div class="w-px h-full bg-gradient-to-b from-indigo-200 to-transparent mt-3 group-last:hidden"></div>
            </div>

            {{-- Main Card --}}
            <div class="flex-1 bg-white border border-slate-200 rounded-3xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                {{-- Journal Entry --}}
                <div class="p-6">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Catatan Refleksi</h4>
                    <p class="text-[14px] text-slate-700 leading-relaxed italic">"{{ $journal->entry }}"</p>
                </div>

                {{-- Task Section --}}
                @php
                    $submission = \App\Models\TaskSubmission::where('program_schedule_id', $journal->program_schedule_id)
                                    ->where('member_id', $journal->member_id)
                                    ->first();
                @endphp

                @if($journal->submission)
                    <div class="bg-slate-50/80 px-4 sm:px-6 py-4 border-t border-slate-100">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            
                            <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-emerald-700 bg-emerald-100/50 px-3 py-1 rounded-full uppercase tracking-wider w-fit">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> 
                                Tugas Dikumpulkan
                            </span>
                            
                            <button wire:click="openTaskDetail({{ $journal->submission->id }})" 
                                    class="w-full sm:w-auto text-[10px] font-black uppercase tracking-widest text-indigo-600 border border-indigo-200 px-4 py-2 rounded-xl hover:bg-indigo-50 transition text-center">
                                Lihat Detail
                            </button>
                        </div>
                        
                        @if($journal->submission->comment)
                            <div class="mt-4 p-3 sm:p-4 bg-white border border-slate-200 rounded-2xl">
                                <span class="block text-[8px] font-black text-slate-400 uppercase mb-1">Feedback Mentor</span>
                                <p class="text-[12px] sm:text-[13px] text-slate-600 leading-relaxed">
                                    {{ $journal->submission->comment }}
                                </p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        <p class="text-[10px] text-slate-400 italic text-center sm:text-left">
                            Tidak ada pengumpulan tugas untuk sesi ini.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-16 px-4 border-2 border-dashed border-slate-200 rounded-3xl">
            <p class="text-slate-400 text-sm font-medium italic">Belum ada catatan jurnal yang tersedia.</p>
        </div>
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
                        <img src="{{ asset('storage/' . $path) }}" class="w-full h-auto rounded-2xl" alt="Tugas">
                    
                    @elseif($extension === 'pdf')
                        <iframe src="{{ asset('storage/' . $path) }}" class="w-full h-[400px]" frameborder="0"></iframe>
                    
                    @else
                        <div class="p-8 text-center">
                            <p class="text-sm text-slate-500">Pratinjau tidak tersedia untuk format .{{ $extension }}</p>
                            <a href="{{ asset('storage/' . $path) }}" target="_blank" class="mt-2 block text-indigo-600 font-bold underline">Download File</a>
                        </div>
                    @endif
                </div>

                @if($selectedSubmission->comment)
                    <div class="p-4 bg-white border border-slate-200 rounded-2xl">
                        <p class="text-[10px] font-bold text-slate-400 uppercase mb-2">Feedback Mentor</p>
                        <p class="text-sm text-slate-700 leading-relaxed">{{ $selectedSubmission->comment }}</p>
                    </div>
                @else
                    <p class="text-sm text-slate-400 italic text-center py-4">Belum ada feedback dari mentor.</p>
                @endif
            </div>
        </div>
    </div>
@endif
</div>