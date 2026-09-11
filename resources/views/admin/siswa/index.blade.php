@extends('layouts.app')
@section('title','Data Siswa – Admin SiDeteksi')

@section('sidebar-menu')
@include('admin.partials.sidebar-menu')
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h4 class="fw-bold mb-0">Data Siswa</h4>
    <p class="text-muted small mb-0">Kelola data siswa dan pantau hasil diagnosa</p>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
      <i class="bi bi-person-plus me-1"></i>Tambah Siswa
    </a>
  </div>
</div>

{{-- Search --}}
<div class="card mb-3">
  <div class="card-body py-3">
    <form method="GET" action="{{ route('admin.siswa.index') }}">
      <div class="input-group" style="max-width:400px">
        <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
        <input type="text" name="search" class="form-control"
               placeholder="Cari nama, NIS, atau email..."
               value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Cari</button>
        @if(request('search'))
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">Reset</a>
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
            <th class="px-4 small">#</th>
            <th class="small">Nama Siswa</th>
            <th class="small">NIS</th>
            <th class="small">Kelas</th>
            <th class="small">Jenis Kelamin</th>
            <th class="small">Diagnosa</th>
            <th class="small">Status Terakhir</th>
            <th class="small text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($siswa as $i => $s)
          <tr>
            <td class="px-4 text-muted small">{{ $siswa->firstItem() + $i }}</td>
            <td>
              <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
                     style="width:34px;height:34px;font-size:.8rem;font-weight:600;flex-shrink:0">
                  {{ strtoupper(substr($s->name, 0, 1)) }}
                </div>
                <div>
                  <p class="mb-0 small fw-semibold">{{ $s->name }}</p>
                  <p class="mb-0 text-muted" style="font-size:.72rem">{{ $s->email }}</p>
                </div>
              </div>
            </td>
            <td class="small">{{ $s->nis ?? '-' }}</td>
            <td class="small">{{ $s->kelas ?? '-' }}</td>
            <td class="small">{{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : ($s->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</td>
            <td class="small text-center">
              <span class="badge bg-secondary rounded-pill">{{ $s->diagnosa_count }}</span>
            </td>
            <td>
              @if($s->diagnosaTerakhir && $s->diagnosaTerakhir->output)
              <span class="badge rounded-pill small" style="background:{{ $s->diagnosaTerakhir->output->warna }}">
                {{ $s->diagnosaTerakhir->output->tingkat }}
              </span>
              @else
              <span class="badge bg-light text-muted small">Belum tes</span>
              @endif
            </td>
            <td class="text-center">
              <div class="d-flex justify-content-center gap-1">
                <a href="{{ route('admin.siswa.show', $s->id) }}"
                   class="btn btn-sm btn-outline-primary" title="Detail">
                  <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('admin.siswa.edit', $s->id) }}"
                   class="btn btn-sm btn-outline-warning" title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>
                <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus"
                        onclick="konfirmasiHapus({{ $s->id }}, '{{ addslashes($s->name) }}')">
                  <i class="bi bi-trash"></i>
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="text-center text-muted py-5">
              <i class="bi bi-people fs-1 d-block mb-2"></i>
              Belum ada data siswa.
              <a href="{{ route('admin.siswa.create') }}">Tambah sekarang</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($siswa->hasPages())
  <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
    <small class="text-muted">
      Menampilkan {{ $siswa->firstItem() }}–{{ $siswa->lastItem() }} dari {{ $siswa->total() }} siswa
    </small>
    {{ $siswa->withQueryString()->links() }}
  </div>
  @endif
</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:1rem;border:none">
      <div class="modal-body text-center p-4">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
             style="width:60px;height:60px;background:#fee2e2">
          <i class="bi bi-trash text-danger fs-3"></i>
        </div>
        <h5 class="fw-bold mb-2">Hapus Data Siswa?</h5>
        <p class="text-muted small mb-1">Kamu akan menghapus data siswa:</p>
        <p class="fw-semibold mb-3" id="namaHapus">-</p>
        <div class="alert alert-warning py-2 small text-start mb-4">
          <i class="bi bi-exclamation-triangle-fill me-1"></i>
          Seluruh riwayat diagnosa siswa ini juga akan ikut terhapus dan
          <strong>tidak dapat dikembalikan</strong>.
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
function konfirmasiHapus(id, nama) {
  document.getElementById('namaHapus').textContent = nama;
  document.getElementById('formHapus').action = `/admin/siswa/${id}`;
  new bootstrap.Modal(document.getElementById('modalHapus')).show();
}
</script>
@endpush