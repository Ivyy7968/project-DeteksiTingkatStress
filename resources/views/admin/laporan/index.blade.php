@extends('layouts.app')
@section('title','Laporan – Admin SiDeteksi')

@section('sidebar-menu')
@include('admin.partials.sidebar-menu')
@endsection

@push('styles')
<style>
  .laporan-tabs {
    display: flex; gap: .4rem; overflow-x: auto; padding-bottom: .25rem; margin-bottom: 1.25rem;
  }
  .laporan-tab {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .55rem 1.1rem; border-radius: .6rem; font-size: .85rem; font-weight: 600;
    text-decoration: none; white-space: nowrap; transition: all .15s;
    color: #6b7280; background: #f3f4f6; border: 1px solid transparent;
  }
  .laporan-tab:hover { background: #e5e7eb; color: #374151; }
  .laporan-tab.active { background: #4f46e5; color: #fff; }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <h4 class="fw-bold mb-0">Laporan</h4>
    <p class="text-muted small mb-0">Data sistem secara menyeluruh</p>
  </div>
</div>

{{-- Tabs --}}
<div class="laporan-tabs">
  <a href="{{ route('admin.laporan.index', ['tab'=>'siswa']) }}" class="laporan-tab {{ $tab==='siswa'?'active':'' }}">
    <i class="bi bi-people"></i> Daftar Siswa
  </a>
  <a href="{{ route('admin.laporan.index', ['tab'=>'riwayat']) }}" class="laporan-tab {{ $tab==='riwayat'?'active':'' }}">
    <i class="bi bi-clock-history"></i> Riwayat Diagnosa
  </a>
  <a href="{{ route('admin.laporan.index', ['tab'=>'gejala']) }}" class="laporan-tab {{ $tab==='gejala'?'active':'' }}">
    <i class="bi bi-clipboard2-pulse"></i> Data Gejala
  </a>
  <a href="{{ route('admin.laporan.index', ['tab'=>'output']) }}" class="laporan-tab {{ $tab==='output'?'active':'' }}">
    <i class="bi bi-activity"></i> Data Diagnosa
  </a>
  <a href="{{ route('admin.laporan.index', ['tab'=>'aturan']) }}" class="laporan-tab {{ $tab==='aturan'?'active':'' }}">
    <i class="bi bi-diagram-3"></i> Data Aturan
  </a>
</div>

  {{-- ═══ TAB: DAFTAR SISWA ═══ --}}
@if($tab === 'siswa')
<div class="card mb-3">
  <div class="card-body py-3">
    <form method="GET" action="{{ route('admin.laporan.index') }}" class="d-flex gap-2 flex-wrap align-items-center">
      <input type="hidden" name="tab" value="siswa">
      <select name="kelas" class="form-select form-select-sm" style="max-width:220px" onchange="this.form.submit()">
        <option value="">Semua Kelas</option>
        @foreach($kelasList as $k)
        <option value="{{ $k }}" {{ request('kelas') === $k ? 'selected' : '' }}>{{ $k }}</option>
        @endforeach
      </select>
      @if(request('kelas'))
      <a href="{{ route('admin.laporan.index', ['tab'=>'siswa']) }}" class="btn btn-sm btn-outline-secondary">Reset</a>
      @endif
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <span><i class="bi bi-people me-2 text-primary"></i>Daftar Siswa</span>
    <a href="{{ route('admin.laporan.cetak.siswa', ['kelas' => request('kelas')]) }}" target="_blank" class="btn btn-sm btn-outline-primary">
      <i class="bi bi-printer me-1"></i>Cetak
    </a>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th class="px-4 small">Nama</th>
            <th class="small">NIS</th>
            <th class="small">Kelas</th>
            <th class="small">Jenis Kelamin</th>
            <th class="small text-center">Diagnosa</th>
            <th class="small">Status Terakhir</th>
          </tr>
        </thead>
        <tbody>
          @forelse($siswa as $s)
          <tr>
            <td class="px-4 small fw-semibold">{{ $s->name }}</td>
            <td class="small">{{ $s->nis ?? '-' }}</td>
            <td class="small">{{ $s->kelas ?? '-' }}</td>
            <td class="small">{{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            <td class="small text-center">{{ $s->diagnosa_count }}</td>
            <td>
              @if($s->diagnosaTerakhir && $s->diagnosaTerakhir->output)
              <span class="badge rounded-pill small" style="background:{{ $s->diagnosaTerakhir->output->warna }}">
                {{ $s->diagnosaTerakhir->output->tingkat }}
              </span>
              @else
              <span class="badge bg-light text-muted small">Belum tes</span>
              @endif
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data siswa.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($siswa->hasPages())
  <div class="card-footer bg-transparent">{{ $siswa->links() }}</div>
  @endif
</div>
@endif

{{-- ═══ TAB: RIWAYAT DIAGNOSA ═══ --}}
@if($tab === 'riwayat')
<div class="card">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <span><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Diagnosa</span>
    <a href="{{ route('admin.laporan.cetak.riwayat') }}" target="_blank" class="btn btn-sm btn-outline-primary">
      <i class="bi bi-printer me-1"></i>Cetak
    </a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th class="px-4 small">Siswa</th>
            <th class="small">Kelas</th>
            <th class="small">Tingkat Stres</th>
            <th class="small">Jumlah Gejala</th>
            <th class="small">Rule</th>
            <th class="small">Tanggal</th>
          </tr>
        </thead>
        <tbody>
          @forelse($riwayatDiagnosa as $d)
          <tr>
            <td class="px-4">
              <p class="mb-0 small fw-semibold">{{ $d->user->name }}</p>
              <p class="mb-0 text-muted" style="font-size:.72rem">{{ $d->user->nis }}</p>
            </td>
            <td class="small text-muted">{{ $d->user->kelas ?? '-' }}</td>
            <td>
              <span class="badge rounded-pill" style="background:{{ $d->output->warna }}">{{ $d->output->tingkat }}</span>
            </td>
            <td class="small text-muted">{{ count($d->gejala_dipilih) }}</td>
            <td class="small text-muted">{{ $d->rule_cocok ?? '-' }}</td>
            <td class="small text-muted">{{ $d->created_at->format('d M Y, H:i') }}</td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center text-muted py-4">Belum ada riwayat diagnosa.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($riwayatDiagnosa->hasPages())
  <div class="card-footer bg-transparent">{{ $riwayatDiagnosa->links() }}</div>
  @endif
</div>
@endif

{{-- ═══ TAB: DATA GEJALA ═══ --}}
@if($tab === 'gejala')
<div class="card">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <span><i class="bi bi-clipboard2-pulse me-2 text-primary"></i>Data Gejala</span>
    <a href="{{ route('admin.laporan.cetak.gejala') }}" target="_blank" class="btn btn-sm btn-outline-primary">
      <i class="bi bi-printer me-1"></i>Cetak
    </a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th class="px-4 small" style="width:90px">Kode</th>
            <th class="small">Nama Gejala</th>
          </tr>
        </thead>
        <tbody>
          @forelse($gejala as $g)
          <tr>
            <td class="px-4"><span class="badge bg-primary-subtle text-primary">{{ $g->kode }}</span></td>
            <td class="small">{{ $g->nama }}</td>
          </tr>
          @empty
          <tr><td colspan="2" class="text-center text-muted py-4">Belum ada data gejala.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($gejala->hasPages())
  <div class="card-footer bg-transparent">{{ $gejala->links() }}</div>
  @endif
</div>
@endif

{{-- ═══ TAB: DATA OUTPUT ═══ --}}
@if($tab === 'output')
<div class="card">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <span><i class="bi bi-activity me-2 text-primary"></i>Data Diagnosa (Tingkat Stres)</span>
    <a href="{{ route('admin.laporan.cetak.output') }}" target="_blank" class="btn btn-sm btn-outline-primary">
      <i class="bi bi-printer me-1"></i>Cetak
    </a>
  </div>
  <div class="card-body p-0">
    @foreach($outputList as $o)
    <div class="px-4 py-3 border-bottom">
      <div class="d-flex align-items-center gap-2 mb-2">
        <span class="badge" style="background:{{ $o->warna }}">{{ $o->kode }}</span>
        <strong style="color:{{ $o->warna }}">{{ $o->tingkat }}</strong>
      </div>
      <p class="small text-muted mb-2">{{ $o->deskripsi }}</p>
      <p class="small mb-0"><strong>Rekomendasi:</strong> <span class="text-muted">{{ $o->rekomendasi }}</span></p>
    </div>
    @endforeach
  </div>
</div>
@endif

{{-- ═══ TAB: DATA ATURAN ═══ --}}
@if($tab === 'aturan')
<div class="card">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <span><i class="bi bi-diagram-3 me-2 text-primary"></i>Data Aturan (Rules)</span>
    <a href="{{ route('admin.laporan.cetak.aturan') }}" target="_blank" class="btn btn-sm btn-outline-primary">
      <i class="bi bi-printer me-1"></i>Cetak
    </a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th class="px-4 small" style="width:70px">Kode</th>
            <th class="small">Kondisi Gejala</th>
            <th class="small" style="width:160px">Hasil</th>
          </tr>
        </thead>
        <tbody>
          @forelse($rules as $r)
          <tr>
            <td class="px-4"><span class="badge bg-dark">{{ $r->kode }}</span></td>
            <td class="small">
              @if($r->isNegasi())
              <span class="badge bg-warning-subtle text-warning me-1">TIDAK ADA</span>
              @endif
              @foreach($r->gejalaKode() as $i => $kg)
                @if($i > 0)<span class="text-muted mx-1">{{ $r->isNegasi() ? 'maupun' : 'DAN' }}</span>@endif
                <span class="badge bg-light text-dark border">{{ $kg }}</span>
              @endforeach
            </td>
            <td>
              <span class="badge rounded-pill" style="background:{{ $r->output->warna ?? '#6c757d' }}">
                {{ $r->output->tingkat ?? $r->output_kode }}
              </span>
            </td>
          </tr>
          @empty
          <tr><td colspan="3" class="text-center text-muted py-4">Belum ada data rule.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($rules->hasPages())
  <div class="card-footer bg-transparent">{{ $rules->links() }}</div>
  @endif
</div>
@endif

@endsection