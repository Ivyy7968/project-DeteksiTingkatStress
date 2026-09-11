@extends('layouts.app')
@section('title','Data Aturan – Admin SiDeteksi')

@section('sidebar-menu')
@include('admin.partials.sidebar-menu')
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <h4 class="fw-bold mb-0">Data Aturan (Rule)</h4>
    <p class="text-muted small mb-0">Kelola rule forward chaining yang menentukan hasil diagnosa</p>
  </div>
  <a href="{{ route('admin.rules.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-lg me-1"></i>Tambah Rule
  </a>
</div>

<div class="card mb-3">
  <div class="card-body py-3">
    <form method="GET" action="{{ route('admin.rules.index') }}" class="d-flex gap-2 flex-wrap">
      <select name="output" class="form-select form-select-sm" style="max-width:220px" onchange="this.form.submit()">
        <option value="">Semua Tingkat Stres</option>
        @foreach($outputList as $o)
        <option value="{{ $o->kode }}" {{ request('output') === $o->kode ? 'selected' : '' }}>{{ $o->tingkat }}</option>
        @endforeach
      </select>
      @if(request('output'))
      <a href="{{ route('admin.rules.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
      @endif
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="px-4 small" style="width:70px">Kode</th>
            <th class="small">Kondisi Gejala</th>
            <th class="small" style="width:160px">Hasil (Output)</th>
            <th class="small text-center" style="width:140px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($rules as $r)
          <tr>
            <td class="px-4">
              <span class="badge bg-dark">{{ $r->kode }}</span>
            </td>
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
            <td class="text-center">
              <div class="d-flex justify-content-center gap-1">
                <a href="{{ route('admin.rules.edit', $r->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>
                <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus"onclick="konfirmasiHapusRule({{ $r->id }}, '{{ addslashes($r->kode) }}', '{{ addslashes($r->output->tingkat ?? $r->output_kode) }}')"><i class="bi bi-trash"></i></button>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted py-5">Belum ada data rule.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($rules->hasPages())
  <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
    <small class="text-muted">Menampilkan {{ $rules->firstItem() }}–{{ $rules->lastItem() }} dari {{ $rules->total() }} rule</small>
    {{ $rules->withQueryString()->links() }}
  </div>
  @endif
</div>
{{-- Modal Konfirmasi Hapus Rule --}}
<div class="modal fade" id="modalHapusRule" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:1rem;border:none">
      <div class="modal-body text-center p-4">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
             style="width:60px;height:60px;background:#fee2e2">
          <i class="bi bi-trash text-danger fs-3"></i>
        </div>
        <h5 class="fw-bold mb-2">Hapus Data Aturan?</h5>
        <p class="text-muted small mb-1">Kamu akan menghapus rule:</p>
        <p class="fw-semibold mb-1" id="kodeHapusRule">-</p>
        <p class="text-muted small mb-3" id="outputHapusRule">-</p>
        <div class="alert alert-warning py-2 small text-start mb-4">
          <i class="bi bi-exclamation-triangle-fill me-1"></i>
          Menghapus rule akan <strong>langsung memengaruhi hasil forward chaining</strong>
          pada diagnosa siswa berikutnya dan <strong>tidak dapat dikembalikan</strong>.
        </div>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-outline-secondary w-50" data-bs-dismiss="modal">
            Batal
          </button>
          <form id="formHapusRule" method="POST" class="w-50">
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
function konfirmasiHapusRule(id, kode, output) {
  document.getElementById('kodeHapusRule').textContent = kode;
  document.getElementById('outputHapusRule').textContent = 'Hasil: ' + output;
  document.getElementById('formHapusRule').action = `/admin/aturan/${id}`;
  new bootstrap.Modal(document.getElementById('modalHapusRule')).show();
}
</script>
@endpush