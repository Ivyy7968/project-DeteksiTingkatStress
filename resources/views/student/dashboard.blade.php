@extends('layouts.app')
@section('title','Dashboard Siswa – SiDeteksi')

@section('sidebar-menu')
<li><a href="{{ route('siswa.dashboard') }}" class="nav-link {{ request()->routeIs('siswa.dashboard')?'active':'' }}">
  <i class="bi bi-speedometer2"></i> Dashboard
</a></li>
<li><a href="{{ route('siswa.diagnosa') }}" class="nav-link {{ request()->routeIs('siswa.diagnosa')?'active':'' }}">
  <i class="bi bi-clipboard2-pulse"></i> Mulai Diagnosa
</a></li>
<li><a href="{{ route('siswa.riwayat') }}" class="nav-link {{ request()->routeIs('siswa.riwayat')?'active':'' }}">
  <i class="bi bi-clock-history"></i> Riwayat Diagnosa
</a></li>
@endsection

@section('content')
<div class="mb-4">
  <h4 class="fw-700 mb-0">Halo, {{ Auth::user()->name }} </h4>
  <p class="text-muted small">Selamat datang di SiDeteksi. Periksa kondisi stresmu secara berkala.</p>
</div>

<!-- Info Siswa -->
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-lg-3">
    <div class="card p-3">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-3 p-2" style="background:#ede9fe"><i class="bi bi-person-badge text-primary fs-4"></i></div>
        <div>
          <p class="text-muted mb-0" style="font-size:.78rem">NIS</p>
          <strong>{{ Auth::user()->nis ?? '-' }}</strong>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card p-3">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-3 p-2" style="background:#ecfdf5"><i class="bi bi-mortarboard text-success fs-4"></i></div>
        <div>
          <p class="text-muted mb-0" style="font-size:.78rem">Kelas</p>
          <strong>{{ Auth::user()->kelas ?? '-' }}</strong>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card p-3">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-3 p-2" style="background:#fef3c7"><i class="bi bi-clipboard2-check text-warning fs-4"></i></div>
        <div>
          <p class="text-muted mb-0" style="font-size:.78rem">Total Diagnosa</p>
          <strong>{{ Auth::user()->diagnosa()->count() }}</strong>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card p-3">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-3 p-2" style="background:#fee2e2"><i class="bi bi-heart-pulse text-danger fs-4"></i></div>
        <div>
          <p class="text-muted mb-0" style="font-size:.78rem">Status Terakhir</p>
          <strong style="color:{{ $diagnosaTerakhir?->output?->warna ?? '#6c757d' }}">
            {{ $diagnosaTerakhir?->output?->tingkat ?? 'Belum tes' }}
          </strong>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Ringkasan diagnosa terakhir -->
  <div class="col-lg-7">
    <div class="card h-100">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <span><i class="bi bi-file-medical me-2 text-primary"></i>Hasil Diagnosa Terakhir</span>
        <a href="{{ route('siswa.diagnosa') }}" class="btn btn-sm btn-primary">
          <i class="bi bi-plus me-1"></i>Diagnosa Baru
        </a>
      </div>
      <div class="card-body">
        @if($diagnosaTerakhir)
        <div class="text-center py-2">
          <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
               style="width:80px;height:80px;background:{{ $diagnosaTerakhir->output->warna }}20">
            <i class="bi bi-activity fs-1" style="color:{{ $diagnosaTerakhir->output->warna }}"></i>
          </div>
          <h3 class="fw-700" style="color:{{ $diagnosaTerakhir->output->warna }}">
            {{ $diagnosaTerakhir->output->tingkat }}
          </h3>
          <p class="text-muted small">{{ $diagnosaTerakhir->created_at->diffForHumans() }} · {{ $diagnosaTerakhir->created_at->format('d M Y') }}</p>
          <p class="text-muted">{{ $diagnosaTerakhir->output->deskripsi }}</p>
          <div class="alert border-0 rounded-3 text-start mt-3" style="background:{{ $diagnosaTerakhir->output->warna }}15">
            <h6 class="fw-600 mb-1"><i class="bi bi-lightbulb me-1"></i>Rekomendasi</h6>
            <p class="mb-0 small">{{ $diagnosaTerakhir->output->rekomendasi }}</p>
          </div>
          <p class="text-muted small mt-2">Gejala terdeteksi: {{ count($diagnosaTerakhir->gejala_dipilih) }} gejala
            @if($diagnosaTerakhir->rule_cocok) · Rule: {{ $diagnosaTerakhir->rule_cocok }} @endif
          </p>
        </div>
        @else
        <div class="text-center py-5">
          <i class="bi bi-clipboard2-x fs-1 text-muted mb-3 d-block"></i>
          <p class="text-muted mb-3">Kamu belum pernah melakukan diagnosa.</p>
          <a href="{{ route('siswa.diagnosa') }}" class="btn btn-primary">
            <i class="bi bi-play-circle me-1"></i>Mulai Diagnosa Sekarang
          </a>
        </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Riwayat singkat -->
  <div class="col-lg-5">
    <div class="card h-100">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Terakhir</span>
        <a href="{{ route('siswa.riwayat') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
      </div>
      <div class="card-body p-0">
        @forelse($riwayat as $r)
        <a href="{{ route('siswa.hasil', $r->id) }}" class="d-flex align-items-center gap-3 px-3 py-2 text-decoration-none border-bottom hover-bg">
          <div class="rounded-circle d-flex align-items-center justify-content-center shrink-0"
               style="width:38px;height:38px;background:{{ $r->output->warna }}20">
            <i class="bi bi-activity" style="color:{{ $r->output->warna }}"></i>
          </div>
          <div class="grow min-w-0">
            <p class="mb-0 fw-500 small text-dark text-truncate">{{ $r->output->tingkat }}</p>
            <p class="mb-0 text-muted" style="font-size:.75rem">{{ $r->created_at->format('d M Y') }}</p>
          </div>
          <i class="bi bi-chevron-right text-muted small"></i>
        </a>
        @empty
        <div class="text-center py-4 text-muted small">Belum ada riwayat diagnosa</div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection