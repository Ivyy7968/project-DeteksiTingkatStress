@extends('layouts.app')
@section('title','Data Gejala – Admin SiDeteksi')

@section('sidebar-menu')
@include('admin.partials.sidebar-menu')
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <h4 class="fw-bold mb-0">Data Gejala</h4>
    <p class="text-muted small mb-0">Kelola indikator gejala yang dipakai dalam diagnosa</p>
  </div>
  <a href="{{ route('admin.gejala.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-lg me-1"></i>Tambah Gejala
  </a>
</div>

<div class="card mb-3">
  <div class="card-body py-3">
    <form method="GET" action="{{ route('admin.gejala.index') }}">
      <div class="input-group" style="max-width:400px">
        <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
        <input type="text" name="search" class="form-control" placeholder="Cari kode atau nama gejala..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Cari</button>
        @if(request('search'))
        <a href="{{ route('admin.gejala.index') }}" class="btn btn-outline-secondary">Reset</a>
        @endif
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="px-4 small" style="width:80px">Kode</th>
            <th class="small">Nama Gejala</th>
            <th class="small text-center" style="width:130px">Dipakai di Rule</th>
            <th class="small text-center" style="width:140px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($gejala as $g)
          <tr>
            <td class="px-4">
              <span class="badge bg-primary-subtle text-primary">{{ $g->kode }}</span>
            </td>
            <td class="small">{{ $g->nama }}</td>
            <td class="text-center">
              @php $total = $pemakaian[$g->kode] ?? 0; @endphp
              @if($total > 0)
              <span class="badge bg-secondary rounded-pill">{{ $total }} rule</span>
              @else
              <span class="badge bg-light text-muted">Belum dipakai</span>
              @endif
            </td>
            <td class="text-center">
              <div class="d-flex justify-content-center gap-1">
                <a href="{{ route('admin.gejala.edit', $g->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>
                <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus"onclick="konfirmasiHapus({{ $g->id }}, '{{ addslashes($g->kode) }}', '{{ addslashes($g->nama) }}')"><i class="bi bi-trash"></i></button>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted py-5">Belum ada data gejala.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($gejala->hasPages())
  <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
    <small class="text-muted">Menampilkan {{ $gejala->firstItem() }}–{{ $gejala->lastItem() }} dari {{ $gejala->total() }} gejala</small>
    {{ $gejala->withQueryString()->links() }}
  </div>
  @endif
</div>
{{-- Konfirmasi Hapus Gejala --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:1rem;border:none">
      <div class="modal-body text-center p-4">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
             style="width:60px;height:60px;background:#fee2e2">
          <i class="bi bi-trash text-danger fs-3"></i>
        </div>
        <h5 class="fw-bold mb-2">Hapus Data Gejala?</h5>
        <p class="text-muted small mb-1">Kamu akan menghapus gejala:</p>
        <p class="fw-semibold mb-1" id="kodeHapus">-</p>
        <p class="text-muted small mb-3" id="namaHapus">-</p>
        <div class="alert alert-warning py-2 small text-start mb-4">
          <i class="bi bi-exclamation-triangle-fill me-1"></i>
          Gejala hanya bisa dihapus jika <strong>belum dipakai di rule manapun</strong>.
          Jika masih dipakai, penghapusan akan ditolak otomatis.
        </div>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-outline-secondary w-50" data-bs-dismiss="modal">
            Batal
          </button>
          <form id="formHapus" method="POST" class="w-50">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger w-100">
              <i class="bi bi-trash me-1"></i>Ya, Hapus
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function konfirmasiHapus(id, kode, nama) {
  document.getElementById('kodeHapus').textContent = kode;
  document.getElementById('namaHapus').textContent = nama;
  document.getElementById('formHapus').action = `/admin/gejala/${id}`;
  new bootstrap.Modal(document.getElementById('modalHapus')).show();
}
</script>
@endpush