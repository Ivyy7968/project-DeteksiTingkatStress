@extends('layouts.app')
@section('title','Dashboard Admin – SiDeteksi')

@section('sidebar-menu')
@include('admin.partials.sidebar-menu')
@endsection

@section('content')
<div class="mb-4">
  <h4 class="fw-bold mb-0">Dashboard</h4>
  <p class="text-muted small">Selamat datang, {{ Auth::user()->name }}</p>
</div>

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card p-3" style="border-left: 4px solid #4f46e5">
      <p class="text-muted small mb-1">Total Siswa</p>
      <h3 class="fw-bold mb-0">{{ $totalSiswa }}</h3>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card p-3" style="border-left: 4px solid #28a745">
      <p class="text-muted small mb-1">Sudah Tes</p>
      <h3 class="fw-bold mb-0">{{ $sudahTes }}</h3>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card p-3" style="border-left: 4px solid #ffc107">
      <p class="text-muted small mb-1">Belum Tes</p>
      <h3 class="fw-bold mb-0">{{ $belumTes }}</h3>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card p-3" style="border-left: 4px solid #7c3aed">
      <p class="text-muted small mb-1">Rata-Rata Stres</p>
      <h3 class="fw-bold mb-0" style="font-size:1.2rem">{{ $rataRata }}</h3>
    </div>
  </div>
</div>

<div class="row g-4">

  {{-- Grafik Distribusi Tingkat Stres --}}
  <div class="col-lg-7">
    <div class="card">
      <div class="card-header py-3">
        <i class="bi bi-bar-chart me-2 text-primary"></i>Distribusi Tingkat Stres
      </div>
      <div class="card-body">
        <canvas id="stresChart" style="max-height:280px"></canvas>
      </div>
    </div>
  </div>

  {{-- Grafik Rata-Rata Tes per Kelas --}}
  <div class="col-lg-5">
    <div class="card">
      <div class="card-header py-3">
        <i class="bi bi-clipboard2-check me-2 text-primary"></i>Partisipasi Tes per Kelas
      </div>
      <div class="card-body">
        @if(count($distribusiKelas) > 0)
          <canvas id="kelasChart"></canvas>
        @else
          <div class="text-center py-5 text-muted">
            <i class="bi bi-clipboard2-x fs-1 d-block mb-2"></i>
            Belum ada data kelas yang tersedia.
          </div>
        @endif
      </div>
    </div>
  </div>
  
  {{-- Tabel Diagnosa Terbaru --}}
  <div class="col-12">
    <div class="card">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clock-history me-2 text-primary"></i>Diagnosa Terbaru</span>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th class="px-4 small">Siswa</th>
                <th class="small">Kelas</th>
                <th class="small">Tingkat Stres</th>
                <th class="small">Gejala</th>
                <th class="small">Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @forelse($diagnosaRecent as $d)
              <tr>
                <td class="px-4">
                  <p class="mb-0 small fw-semibold">{{ $d->user->name }}</p>
                  <p class="mb-0 text-muted" style="font-size:.72rem">{{ $d->user->nis }}</p>
                </td>
                <td class="small text-muted">{{ $d->user->kelas ?? '-' }}</td>
                <td>
                  <span class="badge rounded-pill" style="background:{{ $d->output->warna }}">
                    {{ $d->output->tingkat }}
                  </span>
                </td>
                <td class="small text-muted">{{ count($d->gejala_dipilih) }}</td>
                <td class="small text-muted">{{ $d->created_at->format('d M Y') }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">Belum ada data diagnosa</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
const labels     = @json($outputList->pluck('tingkat', 'kode'));
const distribusi = @json($distribusi);
const colors     = @json($outputList->pluck('warna','kode'));
const levels     = ['S1','S2','S3','S4','S5'];
const barData    = levels.map(k => distribusi[k] ?? 0);
const barLabels  = levels.map(k => labels[k] ?? k);
const barColors  = levels.map(k => colors[k] ?? '#ccc');

// ── Grafik Distribusi Tingkat Stres ──
new Chart(document.getElementById('stresChart'), {
  type: 'bar',
  data: {
    labels: barLabels,
    datasets: [{
      label: 'Jumlah Siswa',
      data: barData,
      backgroundColor: barColors.map(c => c + 'cc'),
      borderColor: barColors,
      borderWidth: 2,
      borderRadius: 8,
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { display: false } },
    scales: {
      y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f3f4f6' } },
      x: { grid: { display: false } }
    }
  }
});

// ── Grafik Rata-Rata Stres per Kelas ──
@if(count($distribusiKelas) > 0)
const distribusiKelas = @json($distribusiKelas);
const kelasLabels     = Object.keys(distribusiKelas);
const kelasData       = kelasLabels.map(k => distribusiKelas[k].rata_rata);
const kelasSudahTes   = kelasLabels.map(k => distribusiKelas[k].sudah_tes);
const kelasTotal      = kelasLabels.map(k => distribusiKelas[k].total);

const kelasColors = kelasData.map(v => {
  if (v === 0)   return '#6c757d';
  if (v < 1.5)   return '#28a745';
  if (v < 2.5)   return '#17a2b8';
  if (v < 3.5)   return '#ffc107';
  if (v < 4.5)   return '#fd7e14';
  return '#dc3545';
});

new Chart(document.getElementById('kelasChart'), {
  type: 'bar',
  data: {
    labels: kelasLabels,
    datasets: [{
      label: 'Rata-Rata Tingkat Stres',
      data: kelasData,
      backgroundColor: kelasColors.map(c => c + 'cc'),
      borderColor: kelasColors,
      borderWidth: 2,
      borderRadius: 8,
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: false },
      tooltip: {
        callbacks: {
          label: function(ctx) {
            const i     = ctx.dataIndex;
            const rata  = kelasData[i];
            const sudah = kelasSudahTes[i];
            const total = kelasTotal[i];
            let level = '-';
            if (rata === 0)      level = 'Belum Ada Data';
            else if (rata < 1.5) level = 'Normal';
            else if (rata < 2.5) level = 'Ringan';
            else if (rata < 3.5) level = 'Sedang';
            else if (rata < 4.5) level = 'Berat';
            else                 level = 'Sangat Berat';
            return [
              `Rata-rata: ${rata} (${level})`,
              `Sudah tes: ${sudah} dari ${total} siswa`,
            ];
          }
        }
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        max: 5,
        ticks: {
          stepSize: 1,
          callback: function(v) {
            const map = {0:'0',1:'Normal',2:'Ringan',3:'Sedang',4:'Berat',5:'Kritis'};
            return map[v] ?? v;
          }
        },
        grid: { color: '#f3f4f6' }
      },
      x: { grid: { display: false } }
    }
  }
});
@endif
</script>
@endpush