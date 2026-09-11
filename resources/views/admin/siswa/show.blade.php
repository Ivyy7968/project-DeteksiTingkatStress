@extends('layouts.app')
@section('title','Detail Siswa')

@section('sidebar-menu')
@include('admin.partials.sidebar-menu')
@endsection

@section('content')
<div style="max-width:800px">
  <div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.siswa.index') }}" class="btn btn-sm btn-outline-secondary">
      <i class="bi bi-arrow-left"></i>
    </a>
    <div>
      <h4 class="fw-bold mb-0">Detail Siswa</h4>
      <p class="text-muted small mb-0">Informasi lengkap dan riwayat diagnosa</p>
    </div>
  </div>

  <div class="row g-4">
    <!-- Info siswa -->
    <div class="col-md-4">
      <div class="card text-center p-3">
        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white mx-auto mb-3"
             style="width:64px;height:64px;font-size:1.5rem;font-weight:700">
          {{ strtoupper(substr($siswa->name,0,1)) }}
        </div>
        <h5 class="fw-bold mb-1">{{ $siswa->name }}</h5>
        <p class="text-muted small mb-3">{{ $siswa->email }}</p>
        <div class="text-start">
          <div class="d-flex justify-content-between border-bottom py-2">
            <span class="small text-muted">NIS</span>
            <span class="small fw-semibold">{{ $siswa->nis ?? '-' }}</span>
          </div>
          <div class="d-flex justify-content-between border-bottom py-2">
            <span class="small text-muted">Kelas</span>
            <span class="small fw-semibold">{{ $siswa->kelas ?? '-' }}</span>
          </div>
          <div class="d-flex justify-content-between border-bottom py-2">
            <span class="small text-muted">Jenis Kelamin</span>
            <span class="small fw-semibold">{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
          </div>
          <div class="d-flex justify-content-between py-2">
            <span class="small text-muted">Terdaftar</span>
            <span class="small fw-semibold">{{ $siswa->created_at->format('d M Y') }}</span>
          </div>
        </div>
        <div class="mt-3 d-grid gap-2">
          <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-sm btn-outline-warning">
            <i class="bi bi-pencil me-1"></i>Edit Data
          </a>
        </div>
      </div>
    </div>

    <!-- Riwayat diagnosa -->
    <div class="col-md-8">
      <div class="card">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
          <span>
            <i class="bi bi-clock-history me-2 text-primary"></i> Riwayat Diagnosa ({{ $riwayat->count() }} kali)
          </span>
          @if($riwayat->count() > 0)
          <span class="badge bg-primary rounded-pill">{{ $riwayat->count() }} diagnosa</span>
          @endif
        </div>
        <div class="card-body p-0">
          @forelse($riwayat as $r)
          <div class="d-flex gap-3 px-3 py-3 border-bottom align-items-center">

            {{-- Icon level --}}
            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                 style="width:40px;height:40px;background:{{ $r->output->warna }}20">
              <i class="bi bi-activity" style="color:{{ $r->output->warna }}"></i>
            </div>

            {{-- Info --}}
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between align-items-center flex-wrap gap-1">
                <span class="badge rounded-pill" style="background:{{ $r->output->warna }}">
                  {{ $r->output->tingkat }}
                </span>
                <span class="text-muted small">{{ $r->created_at->format('d M Y, H:i') }}</span>
              </div>
              <p class="text-muted small mt-1 mb-0">
                {{ count($r->gejala_dipilih) }} gejala terdeteksi
                @if($r->rule_cocok)
                  &middot; Rule: <strong>{{ $r->rule_cocok }}</strong>
                @endif
              </p>
            </div>

            {{-- Tombol Cetak --}}
            <a href="{{ route('admin.diagnosa.cetak', $r->id) }}"
               target="_blank"
               class="btn btn-sm btn-outline-primary flex-shrink-0"
               title="Cetak hasil diagnosa ini">
              <i class="bi bi-printer me-1"></i>Cetak
            </a>

          </div>
          @empty
          <div class="text-center py-5 text-muted">
            <i class="bi bi-clipboard2-x fs-1 d-block mb-2"></i>
            Siswa belum pernah melakukan diagnosa.
          </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection