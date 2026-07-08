<div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm" x-data="{ selectedDate: '{{ $selectedDate }}' }">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
        <h2 class="text-sm font-medium text-slate-700 flex items-center gap-2">
            <x-heroicon-o-table-cells class="w-4 h-4 text-slate-400" />
            Jadwal materi per hari
        </h2>
        <button wire:click="save"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white
                       text-sm font-medium px-5 py-2 rounded-lg transition cursor-pointer">
            <x-heroicon-o-cloud-arrow-up class="w-4 h-4" />
            Simpan semua
        </button>
    </div>

    {{-- Notifikasi --}}
    @if(session()->has('message'))
        <div class="mb-4 flex items-center gap-2 text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg px-4 py-2.5">
            <x-heroicon-o-check-circle class="w-4 h-4 shrink-0" />
            {{ session('message') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="mb-4 flex items-center gap-2 text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg px-4 py-2.5">
            <x-heroicon-o-x-circle class="w-4 h-4 shrink-0" />
            {{ session('error') }}
        </div>
    @endif

    {{-- Slider tanggal --}}
    <div class="relative w-full mb-5">
        <div class="flex gap-2 overflow-x-auto pb-3 scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent snap-x">
            @foreach($this->dates as $date)
                @php $dateKey = $date->format('Y-m-d'); @endphp
                <button
                    type="button"
                    @click="selectedDate = '{{ $dateKey }}'; $el.scrollIntoView({behavior: 'smooth', block: 'nearest', inline: 'center'});"
                    :class="selectedDate === '{{ $dateKey }}'
                        ? 'bg-indigo-600 text-white border-indigo-600 shadow-sm'
                        : 'bg-white text-slate-500 border-slate-200 hover:border-indigo-300 hover:text-indigo-500'"
                    class="shrink-0 min-w-[52px] px-3 py-2 rounded-xl border text-center transition snap-center cursor-pointer"
                >
                    <div class="text-[10px]" :class="selectedDate === '{{ $dateKey }}' ? 'text-indigo-200' : 'text-slate-400'">
                        {{ $date->translatedFormat('D') }}
                    </div>
                    <div class="text-sm font-semibold leading-tight">
                        {{ $date->format('d') }}
                    </div>
                    <div class="text-[10px]" :class="selectedDate === '{{ $dateKey }}' ? 'text-indigo-200' : 'text-slate-400'">
                        {{ $date->translatedFormat('M') }}
                    </div>
                </button>
            @endforeach
        </div>
    </div>

    {{-- Form per tanggal (Looping semua untuk di-toggle Alpine) --}}
    @foreach($this->dates as $date)
        @php 
            $dateKey = $date->format('Y-m-d'); 
            $sessionNo = $loop->iteration;
        @endphp
        
        <div x-show="selectedDate === '{{ $dateKey }}'" x-cloak>
            <div class="border border-slate-200 rounded-xl overflow-hidden transition-colors">
                <div class="flex items-center justify-between px-4 py-2.5 bg-slate-50 border-b border-slate-200">
                    <span class="text-sm font-medium text-slate-700 flex items-center gap-2">
                        <x-heroicon-o-calendar-days class="w-4 h-4 text-slate-400" />
                        {{ $date->translatedFormat('l, d M Y') }}
                    </span>
                    <span class="text-[11px] text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md">
                        Sesi ke-{{ $sessionNo }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-slate-100">
                    {{-- Kolom 1: Info --}}
                    <div class="p-4">
                        <div class="flex items-center gap-2 mb-3 pb-2.5 border-b border-slate-100">
                            <x-heroicon-o-calendar class="w-3.5 h-3.5 text-indigo-400" />
                            <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wide">Hari / tanggal</span>
                        </div>
                        <p class="text-sm text-slate-600">{{ $date->translatedFormat('l') }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $date->format('d M Y') }}</p>
                    </div>

                    {{-- Kolom 2: Produk --}}
                    <div class="p-4">
                        <div class="flex items-center gap-2 mb-3 pb-2.5 border-b border-slate-100">
                            <x-heroicon-o-book-open class="w-3.5 h-3.5 text-indigo-400" />
                            <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wide">Produk / materi</span>
                        </div>
                        @foreach(($schedules[$dateKey] ?? []) as $index => $selectedId)
                            <div class="flex items-center gap-2 mb-2">
                                <select wire:model="schedules.{{ $dateKey }}.{{ $index }}" class="w-full text-xs border border-slate-200 rounded-lg px-2.5 py-1.5 focus:ring-2 focus:ring-indigo-400">
                                    <option value="">Pilih produk…</option>
                                    @foreach($allProducts as $product)
                                        <option value="{{ $product->id }}">{{ $product->title }}</option>
                                    @endforeach
                                </select>
                                <button type="button" wire:click="removeProductSlot('{{ $dateKey }}', {{ $index }})" class="text-slate-300 hover:text-red-400 p-1.5 rounded-lg">
                                    <x-heroicon-o-x-mark class="w-3.5 h-3.5" />
                                </button>
                            </div>
                        @endforeach
                        <button type="button" wire:click="addProductSlot('{{ $dateKey }}')" class="text-[11px] text-indigo-500 border border-dashed border-indigo-300 rounded-lg px-2.5 py-1.5 mt-1 flex items-center gap-1">
                            <x-heroicon-o-plus class="w-3 h-3" /> Tambah produk
                        </button>
                    </div>

                    {{-- Kolom 3: Tugas --}}
                    <div class="p-4">
                        {{-- Header setara: Judul di kiri, Checkbox di kanan --}}
                        <div class="flex items-center justify-between mb-3 pb-2.5 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <x-heroicon-o-clipboard-document-list class="w-3.5 h-3.5 text-amber-400" />
                                <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wide">Tugas</span>
                            </div>
                            
                            <label class="flex items-center gap-1.5 cursor-pointer group">
                                <span class="text-[10px] font-bold text-slate-500 uppercase group-hover:text-indigo-600 transition">
                                    Izinkan Upload
                                </span>
                                <input type="checkbox" 
                                    wire:model.live="uploadSettings.{{ $dateKey }}.upload" 
                                    class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-3.5 h-3.5 cursor-pointer">
                            </label>
                        </div>

                        {{-- List Tugas --}}
                        @foreach(($tasks[$dateKey] ?? []) as $taskIndex => $task)
                            <div class="mb-2 flex gap-2">
                                <input type="text" wire:model="tasks.{{ $dateKey }}.{{ $taskIndex }}.task" placeholder="Tulis tugas…" class="w-full text-xs border border-slate-200 rounded-lg px-2.5 py-1.5 focus:border-indigo-300">
                                <button type="button" wire:click="removeTaskSlot('{{ $dateKey }}', {{ $taskIndex }})" class="text-slate-300 hover:text-red-400">
                                    <x-heroicon-o-x-mark class="w-3.5 h-3.5" />
                                </button>
                            </div>
                        @endforeach
                        
                        <button type="button" wire:click="addTaskSlot('{{ $dateKey }}')" class="text-[11px] text-amber-600 border border-dashed border-amber-300 rounded-lg px-2.5 py-1.5 mt-1 flex items-center gap-1 hover:bg-amber-50">
                            <x-heroicon-o-plus class="w-3 h-3" /> Tambah tugas
                        </button>
                    </div>
                </div>
            </div>
        
        @php $submissions = $this->getMemberSubmissions($dateKey); @endphp

        <div class="space-y-2 mt-5">
            @forelse($this->getMemberSubmissions($dateKey) as $submission)
                <div class="flex items-center justify-between p-2 bg-slate-50 border border-slate-100 rounded-lg hover:border-slate-200 transition">
                    {{-- Menggunakan relasi member --}}
                    <p class="text-xs font-medium text-slate-700 truncate w-1/2">
                        {{ $submission->member->name ?? 'Member Tidak Ditemukan' }}
                    </p>

                    <div class="flex items-center gap-1.5">
                        <a href="{{ Storage::url($submission->file_path) }}" target="_blank" 
                        class="text-[10px] font-medium bg-white border border-slate-200 text-slate-600 px-2.5 py-1 rounded-md hover:bg-slate-50 transition">
                            Lihat
                        </a>
                        
                        <button
                            type="button"
                            wire:click="openCommentModal({{ $submission->id }})"
                            class="text-[10px] font-medium bg-indigo-600 text-white px-2.5 py-1 rounded-md"
                        >
                            {{ $submission->comment ? 'Edit Komentar' : 'Komentari' }}
                        </button>
                        
                    </div>
                </div>
            @empty
                <div class="text-center py-6 text-xs text-slate-400 italic border-2 border-dashed border-slate-100 rounded-lg">
                    Belum ada tugas di tanggal ini.
                </div>
            @endforelse
        </div>
    </div>
@endforeach
@if($showCommentModal)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-5">

        <h3 class="text-lg font-semibold mb-4">
            Komentar Tugas
        </h3>

        <textarea
            wire:model="commentText"
            rows="5"
            class="w-full border border-slate-300 rounded-lg p-3"
            placeholder="Tulis komentar..."
        ></textarea>

        <div class="flex justify-end gap-2 mt-4">

            <button
                type="button"
                wire:click="closeCommentModal"
                class="px-4 py-2 border rounded-lg"
            >
                Batal
            </button>

            <button
                type="button"
                wire:click="saveComment"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg"
            >
                Simpan
            </button>

        </div>
    </div>
</div>
@endif
</div>