<div class="p-4 max-w-7xl mx-auto space-y-6">
@if (session()->has('message'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
        {{ session('message') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
        {{ session('error') }}
    </div>
@endif
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @php
      $cards = [
        ['title' => 'Total member', 'value' => $members->total(), 'desc' => 'orang terdaftar'],
        ['title' => 'Produk dipilih', 'value' => count($selectedProducts), 'desc' => 'dari ' . $allProducts->count() . ' produk'],
        ['title' => 'Link Zoom', 'value' => count(array_filter($zoomLinks)), 'desc' => 'link aktif'],
        ['title' => 'Sesi berikutnya', 'value' => 'Senin', 'desc' => '16 Jun 2025, 09.00']
      ];
    @endphp
    @foreach($cards as $card)
    <div class="bg-white border border-slate-100 shadow-sm rounded-xl p-5">
      <p class="text-xs text-slate-400 mb-1">{{ $card['title'] }}</p>
      <p class="text-2xl font-semibold text-slate-800">{{ $card['value'] }}</p>
      <p class="text-xs text-slate-400 mt-0.5">{{ $card['desc'] }}</p>
    </div>
    @endforeach
  </div>

  <div x-data="{ tab: 'ringkasan' }" class="space-y-6">
    
    <div class="mb-6">
        <div class="inline-flex p-1 bg-slate-100 rounded-xl">
            @foreach(['ringkasan' => 'Ringkasan', 'landingpage' => 'Landing Page', 'materi' => 'Materi', 'webinar' => 'Webinar', 'member' => 'Member'] as $key => $label)
            <button
                @click="tab='{{ $key }}'"
                :class="tab === '{{ $key }}' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                class="cursor-pointer px-5 py-2 rounded-lg font-semibold text-sm transition-all">
                {{ $label }}
            </button>
            @endforeach
        </div>
    </div>

    <div x-show="tab === 'landingpage'" class="p-6 bg-white rounded-xl border border-slate-100 shadow-sm">
      @include('livewire.admin.program.components.landing-page', ['section' => $section, 'subPages' => $subPages])
    </div>

    <div x-show="tab === 'webinar'" class="bg-white border border-slate-100 shadow-sm rounded-xl p-6">
      @include('livewire.admin.program.components.webinar')
    </div>

    <div x-show="tab === 'materi'" class="space-y-6">
      @include('livewire.admin.program.components.materi')
    </div>

    <div x-show="tab === 'member'" class="bg-white border border-slate-100 shadow-sm rounded-xl p-6">
      @include('livewire.admin.program.components.member')
    </div>

  </div>
</div>