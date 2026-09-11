@extends('layouts.app')
@section('title','Riwayat Diagnosa')

@section('sidebar-menu')
<li><a href="{{ route('siswa.dashboard') }}" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
<li><a href="{{ route('siswa.diagnosa') }}" class="nav-link"><i class="bi bi-clipboard2-pulse"></i> Mulai Diagnosa</a></li>
<li><a href="{{ route('siswa.riwayat') }}" class="nav-link active"><i class="bi bi-clock-history"></i> Riwayat</a></li>
@endsection

@push('styles')
<link href="{{ asset('css/riwayat.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h4 class="fw-bold mb-0">Riwayat Diagnosa</h4>
    <p class="text-muted small mb-0">Semua diagnosa yang pernah kamu lakukan</p>
  </div>
</div>

@if($riwayat->count() > 0)
{{-- Ringkasan singkat --}}
<div class="row g-3 mb-4">
  <div class="col-sm-4">
    <div class="card p-3 text-center">
      <p class="text-muted small mb-1">Total Diagnosa</p>
      <h4 class="fw-bold mb-0 text-primary">{{ $riwayat->total() }}</h4>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card p-3 text-center">
      <p class="text-muted small mb-1">Diagnosa Terakhir</p>
      <h6 class="fw-bold mb-0" style="font-size:.9rem">
        {{ $riwayat->first()->created_at->format('d M Y') }}
      </h6>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card p-3 text-center">
      <p class="text-muted small mb-1">Hasil Terakhir</p>
      <span class="badge rounded-pill px-3 py-1 fw-semibold"
            style="background:{{ $riwayat->first()->output->warna }};font-size:.8rem">
        {{ $riwayat->first()->output->tingkat }}
      </span>
    </div>
  </div>
</div>
@endif

<div class="card">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <span class="fw-semibold">
      <i class="bi bi-clock-history me-2 text-primary"></i>Semua Riwayat
    </span>
    @if($riwayat->count() > 0)
    <span class="badge bg-primary-subtle text-primary rounded-pill">
      {{ $riwayat->total() }} diagnosa
    </span>
    @endif
  </div>
  <div class="card-body p-0">
    @forelse($riwayat as $i => $r)
    <div class="riwayat-item">

      {{-- Nomor --}}
      <div class="nomor-urut">
        {{ ($riwayat->currentPage() - 1) * $riwayat->perPage() + $i + 1 }}
      </div>

      {{-- Icon --}}
      <div class="riwayat-icon" style="background:{{ $r->output->warna }}18">
        <i class="bi bi-activity" style="color:{{ $r->output->warna }}"></i>
      </div>

      {{-- Info --}}
      <div class="riwayat-info">
        <div class="riwayat-level" style="color:{{ $r->output->warna }}">
          {{ $r->output->tingkat }}
        </div>
        <div class="riwayat-meta">
          <span><i class="bi bi-calendar3 me-1"></i>{{ $r->created_at->format('d M Y') }}</span>
          <div class="riwayat-meta-dot"></div>
          <span><i class="bi bi-clock me-1"></i>{{ $r->created_at->format('H:i') }} WIB</span>
          <div class="riwayat-meta-dot"></div>
          <span><i class="bi bi-list-check me-1"></i>{{ count($r->gejala_dipilih) }} gejala</span>
          <div class="riwayat-meta-dot"></div>
          <span style="font-size:.72rem">{{ $r->created_at->diffForHumans() }}</span>
        </div>
      </div>

      {{-- Actions --}}
      <div class="riwayat-actions">
        <a href="{{ route('siswa.hasil.cetak', $r->id) }}"
           target="_blank"
           class="btn-cetak"
           title="Cetak hasil diagnosa">
          <i class="bi bi-printer"></i>
          <span class="d-none d-sm-inline">Cetak</span>
        </a>
        <a href="{{ route('siswa.hasil', $r->id) }}"
           class="btn-detail"
           title="Lihat detail diagnosa">
          <i class="bi bi-eye"></i>
          <span class="d-none d-sm-inline">Detail</span>
        </a>
      </div>

    </div>
    @empty
    <div class="text-center py-5">
      <div class="mb-3">
        <i class="bi bi-clipboard2-x" style="font-size:3rem;color:#d1d5db"></i>
      </div>
      <h6 class="fw-semibold text-muted mb-1">Belum ada riwayat diagnosa</h6>
      <p class="text-muted small mb-3">Mulai diagnosa pertamamu sekarang</p>
      <a href="{{ route('siswa.diagnosa') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-clipboard2-pulse me-1"></i>Mulai Diagnosa
      </a>
    </div>
    @endforelse
  </div>

  @if($riwayat->hasPages())
  <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
    <small class="text-muted">
      Menampilkan {{ $riwayat->firstItem() }}–{{ $riwayat->lastItem() }}
      dari {{ $riwayat->total() }} diagnosa
    </small>
    {{ $riwayat->links() }}
  </div>
  @endif
</div>
@endsection