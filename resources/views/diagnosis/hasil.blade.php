@extends('layouts.app')
@section('title','Hasil Diagnosa – SiDeteksi')
@section('sidebar-menu')
<li><a href="{{ route('siswa.dashboard') }}" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
<li><a href="{{ route('siswa.diagnosa') }}" class="nav-link"><i class="bi bi-clipboard2-pulse"></i> Mulai Diagnosa</a></li>
<li><a href="{{ route('siswa.riwayat') }}" class="nav-link"><i class="bi bi-clock-history"></i> Riwayat</a></li>
@endsection

@push('styles')
<link href="{{ asset('css/hasil.css') }}" rel="stylesheet">
@endpush

@section('content')
<div style="max-width:780px;margin:0 auto">

  {{-- Breadcrumb --}}
  <nav class="mb-4 d-flex align-items-center gap-2">
    <a href="{{ route('siswa.dashboard') }}" class="text-muted small text-decoration-none"><i class="bi bi-house me-1"></i>Dashboard</a>
    <i class="bi bi-chevron-right text-muted" style="font-size:.7rem"></i>
    <a href="{{ route('siswa.riwayat') }}" class="text-muted small text-decoration-none">Riwayat</a>
    <i class="bi bi-chevron-right text-muted" style="font-size:.7rem"></i>
    <span class="text-muted small">Hasil Diagnosa</span>
  </nav>

  {{-- Result Hero --}}
  <div class="result-hero mb-4"
       style="background:linear-gradient(135deg, {{ $diagnosa->output->warna }}dd, {{ $diagnosa->output->warna }}99);border:none">
    <div class="mb-3">
      <span class="level-badge" style="background:rgba(255,255,255,.2);backdrop-filter:blur(6px);border:1.5px solid rgba(255,255,255,.3)">
        <i class="bi bi-activity"></i>
        {{ $diagnosa->output->tingkat }}
      </span>
    </div>
    <div class="info-strip">
      <div class="info-strip-item">
        <i class="bi bi-calendar3"></i>
        {{ $diagnosa->created_at->format('d F Y') }}
      </div>
      <div class="info-strip-item">
        <i class="bi bi-clock"></i>
        {{ $diagnosa->created_at->format('H:i') }} WIB
      </div>
      <div class="info-strip-item">
        <i class="bi bi-list-check"></i>
        {{ count($diagnosa->gejala_dipilih) }} gejala terdeteksi
      </div>
      @if($diagnosa->rule_cocok)
      <div class="info-strip-item">
        <i class="bi bi-cpu"></i>
        {{ $diagnosa->rule_cocok }}
      </div>
      @endif
    </div>
  </div>

  {{-- Alert Kritis --}}
  @if(in_array($diagnosa->output_kode, ['S4','S5']))
  <div class="alert alert-danger d-flex gap-2 mb-4" style="border-radius:.85rem;border-left:4px solid #dc3545">
    <i class="bi bi-exclamation-triangle-fill mt-1 flex-shrink-0"></i>
    <div>
      <strong>Perhatian!</strong> Tingkat stres kamu memerlukan perhatian segera.
      Segera hubungi guru BK, psikolog sekolah, atau orang tua/wali.
    </div>
  </div>
  @endif

  <div class="row g-4">
    <div class="col-md-7">

      {{-- Deskripsi --}}
      <div class="card mb-3">
        <div class="card-header py-3">
          <i class="bi bi-info-circle me-2" style="color:{{ $diagnosa->output->warna }}"></i>
          Penjelasan Kondisi
        </div>
        <div class="card-body">
          <p class="mb-0 text-muted" style="line-height:1.7">{{ $diagnosa->output->deskripsi }}</p>
        </div>
      </div>

      {{-- Rekomendasi --}}
      <div class="card">
        <div class="card-header py-3"><i class="bi bi-lightbulb me-2 text-warning"></i>Rekomendasi Tindakan</div>
        <div class="card-body">
          <p class="mb-0 text-muted" style="line-height:1.7">{{ $diagnosa->output->rekomendasi }}</p>
        </div>
      </div>

    </div>
    <div class="col-md-5">

      {{-- Gejala --}}
      <div class="card mb-3">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
          <span><i class="bi bi-list-check me-2 text-primary"></i>Gejala Terdeteksi</span>
          <span class="badge bg-primary-subtle text-primary rounded-pill">
            {{ count($diagnosa->gejala_dipilih) }}
          </span>
        </div>
        <div class="card-body">
          @if($gejalaDipilih->count() > 0)
          <div class="d-flex flex-wrap gap-1 mb-3">
            @foreach($gejalaDipilih as $g)
            <span class="gejala-tag" title="{{ $g->nama }}">
              <i class="bi bi-dot text-danger"></i>{{ $g->kode }}
            </span>
            @endforeach
          </div>
          <div>
            @foreach($gejalaDipilih as $g)
            <div class="gejala-list-item">
              <span class="gejala-badge-code">{{ $g->kode }}</span>
              <span class="small text-muted">{{ $g->nama }}</span>
            </div>
            @endforeach
          </div>
          @else
          <div class="text-center py-3">
            <i class="bi bi-clipboard2-x text-muted fs-3 d-block mb-1"></i>
            <p class="text-muted small mb-0">Tidak ada gejala yang dipilih.</p>
          </div>
          @endif
        </div>
      </div>

      {{-- Actions --}}
      <div class="d-grid gap-2">
        <a href="{{ route('siswa.hasil.cetak', $diagnosa->id) }}"
           target="_blank" class="btn-action-outline">
          <i class="bi bi-printer"></i>Cetak Hasil
        </a>
        <a href="{{ route('siswa.diagnosa') }}" class="btn-action-primary">
          <i class="bi bi-arrow-repeat"></i>Diagnosa Ulang
        </a>
        <a href="{{ route('siswa.riwayat') }}" class="btn-action-ghost">
          <i class="bi bi-clock-history"></i>Lihat Riwayat
        </a>
        <a href="{{ route('siswa.dashboard') }}" class="btn-action-ghost">
          <i class="bi bi-house"></i>Kembali ke Dashboard
        </a>
      </div>

    </div>
  </div>
</div>
@endsection