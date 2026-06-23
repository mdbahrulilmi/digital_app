<div class="space-y-6">
    @forelse($journalsLog as $journal)
        <div class="flex gap-6 group">
            {{-- Date Column --}}
            <div class="flex flex-col items-center shrink-0 w-12 pt-1">
                <span class="text-[13px] font-bold text-slate-900 leading-none">
                    {{ $journal->created_at->format('d M') }}
                </span>
                <span class="text-[10px] font-medium text-slate-400 mt-0.5">
                    {{ $journal->created_at->format('Y') }}
                </span>
                <div class="w-px h-full bg-slate-200 mt-2 group-last:hidden"></div>
            </div>

            {{-- Gabungan Card Content --}}
            <div class="flex-1 bg-white border border-slate-200 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.03)] overflow-hidden">
                {{-- Journal Entry --}}
                <div class="p-5 border-b border-slate-100">
                    <p class="text-[14px] text-slate-700 leading-relaxed">{{ $journal->entry }}</p>
                </div>

                {{-- Task Section --}}
                @php
                    $submission = \App\Models\TaskSubmission::where('program_schedule_id', $journal->program_schedule_id)
                                    ->where('member_id', $journal->member_id)
                                    ->first();
                @endphp

                @if($submission)
                    <div class="bg-slate-50/50 p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-100/50 px-2 py-0.5 rounded uppercase">
                                ✓ Telah mengumpulkan tugas
                            </span>
                            <div class="flex gap-2">
                                <button class="text-[10px] font-bold text-indigo-600 border border-indigo-200 px-3 py-1 rounded-md hover:bg-indigo-50 transition">
                                    Lihat Tugas
                                </button>
                                @if($submission->comment)
                                    <button class="text-[10px] font-bold text-slate-600 border border-slate-200 px-3 py-1 rounded-md hover:bg-slate-100 transition">
                                        Lihat Komentar
                                    </button>
                                @endif
                            </div>
                        </div>
                        
                        {{-- Komentar Mentor --}}
                        @if($submission->comment)
                            <div class="mt-3 text-[12px] text-slate-600 italic border-l-2 border-slate-300 pl-3">
                                "{{ $submission->comment }}"
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-10">
            <p class="text-slate-400 text-sm italic">Belum ada catatan jurnal yang dibuat.</p>
        </div>
    @endforelse
</div>