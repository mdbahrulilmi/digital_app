<div class="p-6">
    <div class="flex items-end justify-between mb-10">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Jurnal</h2>
        </div>
    </div>

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

            {{-- Card Content --}}
            <div class="flex-1 bg-white border border-slate-200 rounded-2xl p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)] hover:shadow-md transition-all duration-300">
                <p class="text-[14px] text-slate-700 leading-relaxed">
                    {{ $journal->entry }}
                </p>
            </div>
        </div>
        @empty
            <div class="text-center py-10">
                <p class="text-slate-400 text-sm italic">Belum ada catatan jurnal yang dibuat.</p>
            </div>
        @endforelse
    </div>
</div>