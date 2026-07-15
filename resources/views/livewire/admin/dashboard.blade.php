  <style>
    .legend { display: flex; gap: 14px; flex-wrap: wrap; margin-top: 10px; }
    .legend span { display: flex; align-items: center; gap: 5px; font-size: 11px; color: #64748B; }
    .legend-dot { width: 8px; height: 8px; border-radius: 2px; display: inline-block; }
  </style>
</head>
<body>
<div class="mx-auto flex flex-col gap-5">

  <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
        <p class="text-sm text-slate-500">Jumat, 13 Juni 2025 — Selamat datang kembali</p>
    </div>

  <div class="grid gap-2.5 [grid-template-columns:repeat(auto-fit,minmax(130px,1fr))]">
    <div class="bg-white border border-slate-200 rounded-[10px] px-4 py-3.5">
        <p class="text-[11px] text-slate-400 uppercase tracking-[0.04em]">Pendapatan bulan ini</p>
        <p class="mt-1.5 text-[22px] font-bold text-slate-900">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-[10px] px-4 py-3.5">
        <p class="text-[11px] text-slate-400 uppercase tracking-[0.04em]">Lisensi terjual</p>
        <p class="mt-1.5 text-[22px] font-bold text-slate-900">{{ $totalSold }}</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-[10px] px-4 py-3.5">
        <p class="text-[11px] text-slate-400 uppercase tracking-[0.04em]">Pengunjung aktif</p>
        <p class="mt-1.5 text-[22px] font-bold text-slate-900">{{ $activeVisitors }}</p>
        <div class="mt-1 flex items-center gap-[5px] text-[11px] text-slate-500"><span class="rounded-full bg-emerald-100 px-[6px] py-[1px] text-[10px] font-semibold text-emerald-800">Realtime</span></div>
    </div>
    <div class="bg-white border border-slate-200 rounded-[10px] px-4 py-3.5">
        <p class="text-[11px] text-slate-400 uppercase tracking-[0.04em]">Konversi</p>
        <p class="mt-1.5 text-[22px] font-bold text-slate-900">{{ $conversionRate }}%</p>
        <div class="mt-1 flex items-center gap-[5px] text-[11px] text-slate-500">
            <span class="rounded-full bg-emerald-100 px-[6px] py-[1px] text-[10px] font-semibold text-emerald-800">Total visitor: {{ \App\Models\Visitor::count() }}</span>
        </div>
        </div>
    </div>

  <div class="grid gap-4 md:grid-cols-[1.6fr_1fr]">
    <div class="rounded-xl border border-slate-200 bg-white px-5 py-[18px]">
      <div class="mb-4 flex items-center justify-between">
        <span class="mb-4 text-[13px] font-semibold text-slate-800">Pendapatan 1 Tahun terakhir</span>
      </div>
      <div style="position:relative; height:180px;">
        <canvas id="revChart"></canvas>
      </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white px-5 py-[18px]">
      <p class="mb-4 text-[13px] font-semibold text-slate-800">Sumber traffic</p>
      @foreach($trafficData as $label => $group)
        @php
            $count = $group->count();
            $percentage = ($totalVisitors > 0) ? ($count / $totalVisitors) * 100 : 0;
        @endphp
        
        <div class="flex items-center gap-2 border-b border-slate-100 py-[7px] text-xs text-slate-800 last:border-b-0">
            <span class="flex-1">{{ $label }}</span>
            <div class="h-[5px] max-w-20 flex-1 overflow-hidden rounded-full bg-slate-100">
                <div class="h-full rounded-full" style="width: {{ $percentage }}%; background: #4F46E5"></div>
            </div>
            <span class="min-w-8 text-right text-xs font-semibold">{{ round($percentage) }}%</span>
        </div>
      @endforeach
    </div>
    </div>

  <div class="grid gap-4 md:grid-cols-[1.6fr_1fr]">
    <div class="rounded-xl border border-slate-200 bg-white px-5 py-[18px]">
        <p class="mb-4 text-[13px] font-semibold text-slate-800">Produk terlaris</p>

        @forelse($bestSellingProducts as $item)
            @php
                $iconColor = $item->type === 'program' ? '#2563EB' : '#22C55E';

                $svgIcon = ($item->type === 'program')
                    ? '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"> <path d="M22 10 12 5 2 10l10 5 10-5z"/> <path d="M6 12v5c0 1.5 2.7 3 6 3s6-1.5 6-3v-5"/> <path d="M22 10v6"/>
                      </svg>'
                    : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>';
            @endphp

            <div class="flex items-center gap-2.5 border-b border-slate-100 py-2 last:border-b-0" style="display:flex; align-items:center; gap:10px;">
              <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-[15px] text-slate-500" style="background-color: {{ $iconColor }}; color:white;">
                  {!! $svgIcon !!}
              </div>

              <div style="flex:1; min-width:0;">
                  <p class="text-xs font-semibold text-slate-900" style="margin:0;">
                      {{ $item->name }}
                  </p>
              </div>

              <span class="mt-px text-[11px] text-slate-400" style="white-space:nowrap;">
                  {{ $item->total_sold }} lisensi
              </span>
          </div>
        @empty
            <div class="text-center" style="padding:20px 0; color:#94A3B8; font-size:12px;">
                <i class="ti ti-box-off" style="font-size:24px; display:block; margin-bottom:8px;"></i>
                Belum ada produk/program terjual
            </div>
        @endforelse
    </div>

    <div class="rounded-xl border border-slate-200 bg-white px-5 py-[18px]">
        <p class="mb-4 text-[13px] font-semibold text-slate-800">Perangkat pengunjung</p>

        <div style="position:relative; height:160px;">
            <canvas id="devChart"></canvas>
        </div>

        <div class="py-4"></div>

        <div class="flex justify-center items-center gap-6 flex-wrap">
            @foreach(['Desktop', 'Mobile', 'Tablet'] as $device)
                @php
                    $count = isset($deviceData[$device]) ? $deviceData[$device]->count() : 0;
                    $percent = ($totalVisitors > 0)
                        ? round(($count / $totalVisitors) * 100)
                        : 0;
                @endphp

                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <span
                        class="w-2.5 h-2.5 rounded-full"
                        style="background:{{ $device == 'Desktop' ? '#4F46E5' : ($device == 'Mobile' ? '#818CF8' : '#C7D2FE') }}">
                    </span>
                    <span>{{ $device }} {{ $percent }}%</span>
                </div>
            @endforeach
        </div>
      </div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
  const gridC = 'rgba(0,0,0,.06)';
  const textC = '#64748B';
  const chartLabels = {!! json_encode($chartData->keys()) !!};
  const chartValues = {!! json_encode($chartData->values()) !!};

  new Chart(document.getElementById('revChart'), {
    type: 'line',
    data: {
      labels: chartLabels,
      datasets: [{
        label: 'Pendapatan',
        data: chartValues,
        borderColor: '#4F46E5',
        backgroundColor: 'rgba(79,70,229,.08)',
        fill: true,
        tension: .4,
        pointRadius: 3,
        pointBackgroundColor: '#4F46E5',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: { callbacks: {
          label: function(context) {
            return 'Rp ' + context.raw.toLocaleString('id-ID');
          }
        }}
      },
      scales: {
        x: { grid: { color: gridC }, ticks: { color: textC, font: { size: 11 } }, border: { display: false } },
        y: { grid: { color: gridC }, ticks: { color: textC, font: { size: 11 }, callback: v => 'Rp ' + v }, border: { display: false }, min: 0 }
      }
    }
  });

new Chart(document.getElementById('devChart'), {
    type: 'doughnut',
    data: {
        labels: ['Desktop', 'Mobile', 'Tablet'],
        datasets: [{
            data: [
                {{ isset($deviceData['Desktop']) ? $deviceData['Desktop']->count() : 0 }},
                {{ isset($deviceData['Mobile']) ? $deviceData['Mobile']->count() : 0 }},
                {{ isset($deviceData['Tablet']) ? $deviceData['Tablet']->count() : 0 }}
            ],
            backgroundColor: ['#4F46E5', '#818CF8', '#C7D2FE'],
            borderWidth: 0,
            hoverOffset: 4
        }]
    },
    options: {
      responsive: true, maintainAspectRatio: false,
      cutout: '72%',
      plugins: {
        legend: { display: false },
        tooltip: { callbacks: { label: v => v.label + ': ' + v.raw + '%' } }
      }
    }
  });
</script>
