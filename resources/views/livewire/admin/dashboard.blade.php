  <style>
.d { margin: 0 auto; display: flex; flex-direction: column; gap: 1.25rem; }

    /* Header */
    .hdr { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
    .hdr-left h1 { font-size: 20px; font-weight: 600; color: #0F172A; }
    .hdr-left p { font-size: 12px; color: #64748B; margin-top: 3px; }
    .hdr-actions { display: flex; gap: 8px; }
    .btn {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 7px 14px; border-radius: 8px;
      font-size: 12px; font-weight: 500;
      text-decoration: none; border: 1px solid #E2E8F0;
      background: #fff; color: #1E293B; cursor: pointer;
    }
    .btn:hover { background: #F8FAFC; }
    .btn-accent { background: #4F46E5; color: #fff; border-color: #4F46E5; }
    .btn-accent:hover { background: #4338CA; }

    /* Stats */
    .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 10px; }
    .sc { background: #fff; border: 1px solid #E2E8F0; border-radius: 10px; padding: .875rem 1rem; }
    .sc-label { font-size: 11px; color: #94A3B8; letter-spacing: .04em; text-transform: uppercase; }
    .sc-val { font-size: 22px; font-weight: 700; color: #0F172A; margin-top: 6px; }
    .sc-sub { display: flex; align-items: center; gap: 5px; margin-top: 4px; font-size: 11px; color: #64748B; }
    .tag-up { background: #D1FAE5; color: #065F46; padding: 1px 6px; border-radius: 20px; font-size: 10px; font-weight: 600; }
    .tag-down { background: #FEE2E2; color: #991B1B; padding: 1px 6px; border-radius: 20px; font-size: 10px; font-weight: 600; }

    /* Grids */
    .row2 { display: grid; grid-template-columns: 1.6fr 1fr; gap: 1rem; }
    .row3 { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; }
    @media (max-width: 768px) { .row2 { grid-template-columns: 1fr; } }

    /* Cards */
    .card { background: #fff; border: 1px solid #E2E8F0; border-radius: 12px; padding: 1.125rem 1.25rem; }
    .card-title { font-size: 13px; font-weight: 600; color: #1E293B; margin-bottom: 1rem; }
    .card-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
    .card-head .card-title { margin-bottom: 0; }
    .muted { font-size: 11px; color: #94A3B8; }

    /* Source traffic */
    .src-row { display: flex; align-items: center; gap: 8px; padding: 7px 0; border-bottom: 1px solid #F1F5F9; font-size: 12px; color: #1E293B; }
    .src-row:last-child { border-bottom: none; }
    .src-label { flex: 1; }
    .src-val { font-size: 12px; font-weight: 600; min-width: 32px; text-align: right; }
    .seg-bar { flex: 1; height: 5px; background: #F1F5F9; border-radius: 99px; overflow: hidden; max-width: 80px; }
    .seg-fill { height: 100%; border-radius: 99px; }

    /* Product list */
    .prod-row { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid #F1F5F9; }
    .prod-row:last-child { border-bottom: none; }
    .prod-icon { width: 32px; height: 32px; border-radius: 8px; background: #F1F5F9; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #64748B; font-size: 15px; }
    .prod-name { font-size: 12px; font-weight: 600; color: #0F172A; }
    .prod-meta { font-size: 11px; color: #94A3B8; margin-top: 1px; }
    .bar-bg { flex: 1; height: 4px; background: #F1F5F9; border-radius: 99px; overflow: hidden; min-width: 40px; }
    .bar-fill { height: 100%; background: #4F46E5; border-radius: 99px; }

    /* Notifikasi */
    /* .alert-row { display: flex; align-items: flex-start; gap: 9px; padding: 8px 0; border-bottom: 1px solid #F1F5F9; font-size: 12px; color: #475569; }
    .alert-row:last-child { border-bottom: none; }
    .dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; margin-top: 3px; } */

    /* Legend */
    .legend { display: flex; gap: 14px; flex-wrap: wrap; margin-top: 10px; }
    .legend span { display: flex; align-items: center; gap: 5px; font-size: 11px; color: #64748B; }
    .legend-dot { width: 8px; height: 8px; border-radius: 2px; display: inline-block; }
  </style>
</head>
<body>
<div class="d">

  <!-- Header -->
  <div class="hdr">
    <div class="hdr-left">
      <h1>Dashboard</h1>
      <p>Jumat, 13 Juni 2025 — Selamat datang kembali</p>
    </div>
    {{-- <div class="hdr-actions">
      <a href="#" class="btn"><i class="ti ti-download" style="font-size:13px"></i> Ekspor</a>
      <a href="/admin/product" class="btn btn-accent"><i class="ti ti-plus" style="font-size:13px"></i> Produk baru</a>
    </div> --}}
  </div>

  <!-- Stats -->
  <div class="stats">
    <div class="sc">
        <p class="sc-label">Pendapatan bulan ini</p>
        <p class="sc-val">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
    </div>
    <div class="sc">
        <p class="sc-label">Lisensi terjual</p>
        <p class="sc-val">{{ $totalSold }}</p>
    </div>
    <div class="sc">
        <p class="sc-label">Pengunjung aktif</p>
        <p class="sc-val">{{ $activeVisitors }}</p>
        <div class="sc-sub"><span class="tag-up">Realtime</span></div>
    </div>
    <div class="sc">
        <p class="sc-label">Konversi</p>
        <p class="sc-val">{{ $conversionRate }}%</p>
        <div class="sc-sub">
            <span class="tag-up">Total visitor: {{ \App\Models\Visitor::count() }}</span>
        </div>
        </div>
    </div>

  <!-- Row 2: Chart + Traffic Source -->
  <div class="row2">
    <div class="card">
      <div class="card-head">
        <span class="card-title">Pendapatan 7 hari terakhir</span>
        <span class="muted">Rp juta</span>
      </div>
      <div style="position:relative; height:180px;">
        <canvas id="revChart"></canvas>
      </div>
    </div>

    <div class="card">
      <p class="card-title">Sumber traffic</p>
      @foreach($trafficData as $label => $group)
        @php
            $count = $group->count();
            $percentage = ($totalVisitors > 0) ? ($count / $totalVisitors) * 100 : 0;
        @endphp
        
        <div class="src-row">
            <span class="src-label">{{ $label }}</span>
            <div class="seg-bar">
                <div class="seg-fill" style="width: {{ $percentage }}%; background: #4F46E5"></div>
            </div>
            <span class="src-val">{{ round($percentage) }}%</span>
        </div>
      @endforeach
    </div>
    </div>

  <!-- Row 3: Produk + Devices + Notifikasi -->
  <div class="row2">
      <div class="card">
        <p class="card-title">Produk terlaris</p>
        
        @forelse($bestSellingProducts as $item)
          @php
              $barWidth = ($maxSold > 0) ? ($item->total_sold / $maxSold) * 100 : 0;
              $svgIcon = ($item->type === 'program') 
            ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M7 15h10"/><path d="M12 9v2"/><path d="M15 9v2"/><path d="M9 9v2"/></svg>'
            : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>';
          @endphp

          <div class="prod-row">
              <div class="prod-icon" style="color: #4F46E5;">{!! $svgIcon !!}</div>
              <div style="flex:1;min-width:0; padding-right: 10px;">
                  <p class="prod-name">{{ $item->name }}</p>
                  <p class="prod-meta">{{ $item->total_sold }} lisensi • {{ ucfirst($item->type) }}</p>
              </div>
              <div style="  ">
                  <span style="font-size: 10px; color: #64748B;">{{ round($barWidth) }}%</span>
              </div>
          </div>
        @empty
            <div class="text-center" style="padding: 20px 0; color: #94A3B8; font-size: 12px;">
                <i class="ti ti-box-off" style="font-size: 24px; display: block; margin-bottom: 8px;"></i>
                Belum ada produk/program terjual
            </div>
        @endforelse
      </div>

    <div class="card">
      <p class="card-title">Perangkat pengunjung</p>
        <div style="position:relative; height:160px;">
            <canvas id="devChart"></canvas>
        </div>
        <div class="legend">
            @foreach(['Desktop', 'Mobile', 'Tablet'] as $device)
                @php 
                    $count = isset($deviceData[$device]) ? $deviceData[$device]->count() : 0;
                    $percent = ($totalVisitors > 0) ? round(($count / $totalVisitors) * 100) : 0;
                @endphp
                <span>
                    <span class="legend-dot" style="background:{{ $device == 'Desktop' ? '#4F46E5' : ($device == 'Mobile' ? '#818CF8' : '#C7D2FE') }}"></span>
                    {{ $device }} {{ $percent }}%
                </span>
            @endforeach
        </div>
    </div>

    {{-- <div class="card">
      <p class="card-title">Notifikasi</p>
      <div class="alert-row">
        <div class="dot" style="background:#F59E0B"></div>
        <span>Review baru pada <strong>UI Kit Pro</strong> — bintang 5</span>
      </div>
      <div class="alert-row">
        <div class="dot" style="background:#4F46E5"></div>
        <span>Lisensi baru dari pengguna <strong>@budi_d</strong></span>
      </div>
      <div class="alert-row">
        <div class="dot" style="background:#10B981"></div>
        <span>Pembayaran <strong>Rp 650.000</strong> diterima</span>
      </div>
      <div class="alert-row">
        <div class="dot" style="background:#EF4444"></div>
        <span>Refund request dari <strong>Mobile Kit</strong> — perlu ditinjau</span>
      </div>
    </div> --}}
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
