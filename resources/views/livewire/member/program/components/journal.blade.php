@php
    $journals = [
        (object) [
            'date' => '22 Jun', 
            'year' => '2026', 
            'text' => 'Mulai belajar Laravel Eloquent: Hari ini berhasil memahami relasi One-to-Many dengan efisien.', 
            'mood' => '😊'
        ],
        (object) [
            'date' => '20 Jun', 
            'year' => '2026', 
            'text' => 'Debugging API Integration: Sempat kesulitan di bagian middleware, tapi akhirnya teratasi dengan baik.', 
            'mood' => '🤔'
        ],
        (object) [
            'date' => '18 Jun', 
            'year' => '2026', 
            'text' => 'Setup project baru: Inisialisasi project dan setup Tailwind CSS berjalan dengan sangat lancar.', 
            'mood' => '🚀'
        ],
    ];
@endphp

<div class="p-6">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Log Jurnal</h2>
        {{-- Tombol dengan gaya button primary ala Bootstrap --}}
        <button class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow-sm transition-all duration-200 active:scale-95">
            + Tambah Catatan
        </button>
    </div>

    <div class="space-y-6">
        @foreach($journals as $journal)
        <div class="flex gap-6 group">
            {{-- Date Column --}}
            <div class="flex flex-col items-center shrink-0 w-12 pt-1">
                <span class="text-[13px] font-bold text-slate-900 leading-none">{{ $journal->date }}</span>
                <span class="text-[10px] font-medium text-slate-400 mt-0.5">{{ $journal->year }}</span>
                <div class="w-px h-full bg-slate-200 mt-2 group-last:hidden"></div>
            </div>

            {{-- Card Content --}}
            <div class="flex-1 bg-white border border-slate-200 rounded-2xl p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)] hover:shadow-md transition-all duration-300">
                <p class="text-[14px] text-slate-700 leading-relaxed">
                    <span class="font-bold text-slate-900">{{ explode(':', $journal->text)[0] }}:</span>{{ substr($journal->text, strpos($journal->text, ':') + 1) }}
                </p>
                
                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                    <div class="text-lg grayscale hover:grayscale-0 transition-all cursor-default">
                        {{ $journal->mood }}
                    </div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        Entry #{{ $loop->iteration }}
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>