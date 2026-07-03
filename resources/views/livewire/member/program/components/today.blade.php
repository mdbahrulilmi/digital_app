<div class="space-y-12">
    <div x-data="{ show: false, message: '' }" 
        x-on:show-notification.window="
            message = $event.detail.message; 
            show = true; 
            setTimeout(() => show = false, 3000)
        "
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="fixed top-5 right-5 z-50 p-4 bg-slate-600 text-white border border-slate-700 rounded-2xl text-sm font-bold shadow-lg"
        style="display: none;">
        <span x-text="message"></span>
    </div>
    
    @forelse($schedules as $day)
        @php $isToday = \Carbon\Carbon::parse($day->date)->isToday(); @endphp

        @php
            $hasMaterials = $day->materials->isNotEmpty();
            $hasTasks = $day->tasks->isNotEmpty();
            $showHighlightJournal = !$hasMaterials && !$hasTasks;
        @endphp

        <div>
            <div class="p-2 md:p-4 space-y-6">
                {{-- HERO + MATERI --}}
                <div
                    class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-slate-900 via-[#111827] to-[#1E3A8A]
                    border border-slate-700/80
                    shadow-[0_20px_60px_rgba(37,99,235,.18)]">

                    <!-- Blur -->
                    <div class="absolute -top-16 -right-16 sm:-top-24 sm:-right-20 w-44 h-44 sm:w-72 sm:h-72 bg-blue-500/20 rounded-full blur-3xl"></div>

                    <div class="absolute -bottom-14 -left-14 sm:-bottom-20 sm:-left-20 w-40 h-40 sm:w-64 sm:h-64 bg-cyan-400/10 rounded-full blur-3xl"></div>

                    <!-- Circle (desktop only) -->
                    <div class="hidden lg:block absolute top-5 right-6 w-44 h-44 rounded-full border border-white/5"></div>
                    <div class="hidden lg:block absolute top-10 right-12 w-32 h-32 rounded-full border border-blue-400/10"></div>
                    <div class="hidden lg:block absolute top-16 right-20 w-16 h-16 rounded-full border border-cyan-300/10"></div>

                    <!-- Grid -->
                    <div
                        class="absolute inset-0 opacity-[0.04]"
                        style="
                        background-image:
                        linear-gradient(rgba(255,255,255,.15) 1px, transparent 1px),
                        linear-gradient(90deg, rgba(255,255,255,.15) 1px, transparent 1px);
                        background-size:28px 28px;">
                    </div>

                    <div class="relative z-10 p-5 sm:p-6 lg:p-8">

                        <!-- HEADER -->
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">

                            <div>

                                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white leading-tight">
                                    Selamat Datang {{ auth('member')->user()->name }} 👋
                                </h1>

                                <p class="mt-3 text-sm sm:text-base text-slate-300 max-w-xl leading-relaxed">
                                    Lanjutkan pembelajaranmu hari ini.
                                    Semua materi yang perlu dipelajari tersedia di bawah.
                                </p>

                            </div>

                            @if($isToday)

                            <div
                                class="self-start lg:self-auto
                                px-4 py-3
                                rounded-xl
                                bg-white/10
                                backdrop-blur-md
                                border border-white/10">

                                <div class="flex items-center gap-3">

                                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>

                                    <div>

                                        <p class="text-[10px] uppercase tracking-widest text-slate-400">
                                            Hari Ini
                                        </p>

                                        <p class="text-sm font-bold text-white">
                                            {{ \Carbon\Carbon::parse($day->date)->translatedFormat('l, d F Y') }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                            @endif

                        </div>

                        <!-- Divider -->
                        <div class="my-6 lg:my-8 h-px bg-gradient-to-r from-blue-500/40 via-white/10 to-transparent"></div>

                        @if($showHighlightJournal)

                            <div class="mb-6 p-4">

                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </div>

                                    <div class="w-full">
                                        <h3 class="font-bold text-white">Refleksi Hari Ini</h3>
                                        <div class="flex items-center justify-between">
                                            <p class="text-xs text-slate-50">
                                                Tidak ada materi & tugas — isi jurnal
                                            </p>
                                            @if(filled($journalContents[$day->schedules_id] ?? null))
                                                <span class="inline-flex items-center gap-1 rounded-full bg-cyan-500 px-2.5 py-1 text-[11px] font-semibold text-white">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd"/>
                                                    </svg>
                                                    Sudah Diisi
                                                </span>
                                            @endif
                                            
                                        </div>

                                    </div>
                                </div>

                                <textarea
                                    wire:model="journalContents.{{ $day->schedules_id }}"
                                    class="w-full min-h-[140px] rounded-lg border border-emerald-200 bg-slate-50 p-3 text-sm mt-2"
                                    placeholder="Apa yang kamu pelajari hari ini?"></textarea>

                                <div class="flex justify-end mt-3">
                                    <button
                                        wire:click="saveJournal({{ $day->schedules_id }})"
                                        class="px-5 py-2 rounded-lg bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 text-white text-sm font-semibold">
                                        
                                        {{ isset($journalContents[$day->schedules_id]) ? 'Update Catatan' : 'Simpan Catatan' }}
                                    </button>
                                </div>

                            </div>

                            @endif

                        <!-- TITLE -->
                        
                        @if($hasMaterials)
                        <div class="flex items-center gap-3 mb-6">

                            <div class="w-11 h-11 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 flex items-center justify-center flex-shrink-0">

                                <svg
                                    class="w-5 h-5 text-white"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 6v12m6-6H6"/>

                                </svg>

                            </div>

                            <div>

                                <h2 class="text-lg font-bold text-white">
                                    Materi Pembelajaran
                                </h2>

                                <p class="text-sm text-slate-400">
                                    {{ $day->materials->count() }} Materi tersedia
                                </p>

                            </div>

                        </div>

                        <!-- LIST -->
                            <div class="space-y-4">

                                @foreach($day->materials as $product)

                                @php
                                    $type = strtolower($product->type ?? 'default');

                                    $icon = match ($type) {
                                        'video' => 'M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z',
                                        'image' => 'M4 16l4-4a3 3 0 014 0l4 4m-4-4l1-1a3 3 0 014 0l3 3v5H4v-5z',
                                        'pdf'   => 'M7 7h10M7 11h10M7 15h6M6 3h8l4 4v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2z',
                                        'audio' => 'M9 19V6l12-2v13M9 19a2 2 0 11-4 0 2 2 0 014 0zm12-2a2 2 0 11-4 0 2 2 0 014 0z',
                                        'link'  => 'M10 13a5 5 0 007.07 0l1.41-1.41a5 5 0 00-7.07-7.07L10 5m4 6a5 5 0 00-7.07 0L5.5 12.5a5 5 0 007.07 7.07L14 18',
                                        default => 'M12 6v12m6-6H6',
                                    };

                                    $color = match ($type) {
                                        'video' => 'text-red-400',
                                        'image' => 'text-purple-400',
                                        'pdf'   => 'text-orange-400',
                                        'audio' => 'text-pink-400',
                                        'link'  => 'text-cyan-400',
                                        default => 'text-blue-400',
                                    };

                                    $typeLabel = match ($type) {
                                        'video' => 'Video',
                                        'image' => 'Gambar',
                                        'pdf'   => 'PDF',
                                        'audio' => 'Audio',
                                        'link'  => 'Link',
                                        default => 'Materi',
                                    };

                                @endphp

                                <div
                                    class="group relative overflow-hidden rounded-xl
                                    border border-white/10
                                    bg-white/5
                                    backdrop-blur-md
                                    hover:bg-white/10
                                    hover:border-blue-400/40
                                    transition-all duration-300">

                                    <!-- Hover Glow -->
                                    <div
                                        class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-500
                                        bg-gradient-to-r from-blue-500/10 via-transparent to-cyan-400/10">
                                    </div>

                                    <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4">

                                        <!-- LEFT -->
                                        <div class="flex items-center gap-4 flex-1 min-w-0">

                                            <div
                                                class="w-12 h-12 rounded-xl
                                                bg-slate-900
                                                border border-slate-700
                                                flex items-center justify-center
                                                flex-shrink-0
                                                group-hover:border-blue-400
                                                transition">

                                                <svg
                                                    class="w-6 h-6 text-blue-400"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24">

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="{{ $icon }}" />

                                                </svg>

                                            </div>

                                            <div class="min-w-0">

                                                <p class="font-semibold text-white truncate">
                                                    {{ $product->title }}
                                                </p>

                                                <p class="text-xs text-slate-400 mt-1">
                                                  {{ $typeLabel }}
                                                </p>

                                            </div>

                                        </div>

                                        <!-- BUTTON -->
                                        <button
                                            wire:click="openProduct({{ $product->id }})"
                                            class="w-full sm:w-auto
                                            px-6 py-3
                                            rounded-lg
                                            bg-gradient-to-r
                                            from-blue-600
                                            to-cyan-500
                                            hover:from-blue-500
                                            hover:to-cyan-400
                                            text-white
                                            text-xs
                                            font-bold
                                            uppercase
                                            transition-all
                                            duration-300
                                            cursor-pointer">

                                            Akses

                                        </button>

                                    </div>

                                </div>

                                @endforeach

                            </div>
                        @endif

                    </div>

                </div>  
                {{-- TUGAS --}}
                @if($hasTasks)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">

                        <div class="flex items-center gap-3">

                            <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">

                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>

                            </div>

                            <div>

                                <h3 class="font-bold text-slate-800">
                                    Tugas
                                </h3>

                                <p class="text-xs text-slate-500">
                                    {{ $day->tasks->count() }} tugas tersedia
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="p-6">

                            <div class="space-y-3">

                                @foreach($day->tasks as $task)

                                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                                        <p class="text-sm font-medium text-slate-700">
                                            {{ $task->task }}
                                        </p>

                                    </div>

                                @endforeach

                            </div>

                            @php
                                $sub = $submissions->get($day->schedules_id);
                            @endphp

                            @if($sub)

                                <div class="mt-5 flex items-center gap-2 rounded-xl bg-green-50 border border-green-200 px-4 py-3">

                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"/>
                                    </svg>

                                    <div>

                                        <p class="text-sm font-semibold text-green-700">
                                            Tugas sudah dikumpulkan
                                        </p>

                                        <p class="text-xs text-green-600">
                                            {{ \Carbon\Carbon::parse($sub->created_at)->translatedFormat('d M Y • H:i') }}
                                        </p>

                                    </div>

                                </div>

                            @endif

                            @if($day->upload_required)

                                <button
                                    wire:click="openUploadModal({{ $day->schedules_id }})"
                                    wire:loading.attr="disabled"
                                    class="mt-6 w-full rounded-xl bg-blue-600 hover:bg-blue-700 text-white py-3 text-sm font-semibold transition disabled:opacity-50">

                                    {{ $submissions->has($day->schedules_id) ? 'Ubah Jawaban' : 'Kumpulkan Tugas' }}

                                </button>

                            @endif
                            
                        </div>
                        
                    </div>  
                @endif

                {{-- JURNAL --}}
                @if(!$showHighlightJournal)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-100">

                        <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">

                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>

                        </div>

                        <div class="w-full">

                            <h3 class="font-bold text-slate-800">
                                Refleksi Hari Ini
                            </h3>
                                
                            
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-slate-500">
                                    Tuliskan insight atau pembelajaranmu hari ini.
                                </p>
                                @if(filled($journalContents[$day->schedules_id] ?? null))
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-semibold text-emerald-700">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"/>
                                        </svg>
                                        Sudah Diisi
                                    </span>
                                @endif
                                
                            </div>

                        </div>

                    </div>

                    <div class="p-6">

                        <textarea
                            wire:model="journalContents.{{ $day->schedules_id }}"
                            class="w-full min-h-[180px] rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700 placeholder:text-slate-400 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition resize-none"
                            placeholder="Apa hal baru yang kamu pelajari hari ini?"></textarea>

                        <div class="flex justify-end mt-5">

                            <button
                                wire:click="saveJournal({{ $day->schedules_id }})"
                                wire:loading.attr="disabled"
                                class="px-8 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm transition disabled:opacity-50">

                                {{ isset($journalContents[$day->schedules_id]) ? 'Update Catatan' : 'Simpan Catatan' }}

                            </button>

                        </div>

                    </div>

                </div>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-20 text-slate-400 font-medium">Belum ada agenda tersedia.</div>
    @endforelse

    @include('livewire.member.program.components.modals.today-modal')
</div>