<div class="p-4 mx-auto space-y-6">
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <div class="bg-white border border-slate-100 shadow-sm rounded-xl p-5">
        <p class="text-xs text-slate-400 mb-1">Total Member</p>
        <p class="text-2xl font-semibold text-slate-800">{{ $totalMembers }}</p>
        <p class="text-xs text-slate-400 mt-0.5">orang terdaftar</p>
    </div>
    
    <div class="bg-white border border-slate-100 shadow-sm rounded-xl p-5">
        <p class="text-xs text-slate-400 mb-1">Produk Dipilih</p>
        <p class="text-2xl font-semibold text-slate-800">{{ $uniqueProducts }}</p>
        <p class="text-xs text-slate-400 mt-0.5">dari {{ \App\Models\Product::count() }} produk</p>
    </div>

    <div class="bg-white border border-slate-100 shadow-sm rounded-xl p-5">
        <p class="text-xs text-slate-400 mb-1">Hari Aktif</p>
        <p class="text-2xl font-semibold text-slate-800">{{ $activeDays }}</p>
        <p class="text-xs text-slate-400 mt-0.5">sesi terjadwal</p>
    </div>

    <div class="bg-white border border-slate-100 shadow-sm rounded-xl p-5">
        <p class="text-xs text-slate-400 mb-1">Sesi Berikutnya</p>
        <p class="text-2xl font-semibold text-slate-800">
            {{ $nextSession ? \Carbon\Carbon::parse($nextSession->date)->format('D') : '-' }}
        </p>
        <p class="text-xs text-slate-400 mt-0.5">
            {{ $nextSession ? \Carbon\Carbon::parse($nextSession->date)->format('d M Y') : 'Tidak ada sesi' }}
        </p>
    </div>
</div>

  <div x-data="{ tab: 'landingpage' }" class="space-y-6">
    
    <div class="mb-6">
        <div class="inline-flex p-1 bg-slate-100 rounded-xl">
            @foreach(['landingpage' => 'Landing Page', 'materi' => 'Materi', 'webinar' => 'Webinar', 'member' => 'Member'] as $key => $label)
            <button
                @click="tab='{{ $key }}'"
                :class="tab === '{{ $key }}' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                class="cursor-pointer px-5 py-2 rounded-lg font-semibold text-sm transition-all">
                {{ $label }}
            </button>
            @endforeach
        </div>
    </div> 

        <div x-show="tab === 'landingpage'">

            <livewire:admin.program.components.program-landing-page
                :program="$program"
                wire:key="landingpage-{{ $program->id }}"
            />

        </div>

        <div x-show="tab === 'materi'">

            <livewire:admin.program.components.program-schedule-task
                :program="$program"
                wire:key="materi-{{ $program->id }}"
            />

        </div>

        <div x-show="tab === 'webinar'">

            <livewire:admin.program.components.program-zoom
                :program="$program"
                wire:key="zoom-{{ $program->id }}"
            />

        </div>

        <div x-show="tab === 'member'">

            <livewire:admin.program.components.program-member
                :program="$program"
                wire:key="member-{{ $program->id }}"
            />

        </div>

    </div>
</div>