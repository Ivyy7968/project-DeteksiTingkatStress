@extends('layouts.app')
@section('title','Edit Rule')

@section('sidebar-menu')
@include('admin.partials.sidebar-menu')
@endsection

@push('styles')
<style>
  .gejala-check-item {
    border: 1px solid #e5e7eb; border-radius: .5rem; padding: .5rem .75rem;
    display: flex; align-items: flex-start; gap: .5rem; cursor: pointer; transition: all .15s;
  }
  .gejala-check-item:hover { background: #f8f9fc; border-color: #c7d2fe; }
  .gejala-check-item input:checked ~ span { color: #4f46e5; font-weight: 600; }
</style>
@endpush

@section('content')
<div style="max-width:760px">
  <div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.rules.index') }}" class="btn btn-sm btn-outline-secondary">
      <i class="bi bi-arrow-left"></i>
    </a>
    <div>
      <h4 class="fw-bold mb-0">Edit Rule</h4>
      <p class="text-muted small mb-0">{{ $rule->kode }}</p>
    </div>
  </div>

  @if($errors->any())
  <div class="alert alert-danger small">
    <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
  @endif

  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.rules.update', $rule->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label class="form-label fw-semibold small">Kode Rule *</label>
            <input type="text" name="kode" class="form-control" value="{{ old('kode', $rule->kode) }}" required>
          </div>
          <div class="col-md-8">
            <label class="form-label fw-semibold small">Hasil / Tingkat Stres *</label>
            <select name="output_kode" class="form-select" required>
              @foreach($outputList as $o)
              <option value="{{ $o->kode }}" {{ old('output_kode', $rule->output_kode) === $o->kode ? 'selected' : '' }}>{{ $o->tingkat }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" name="is_negasi" value="1" id="isNegasi"
                 {{ old('is_negasi', $isNegasi) ? 'checked' : '' }}>
          <label class="form-check-label small" for="isNegasi">
            Jadikan rule negasi (terpicu jika <strong>TIDAK ADA</strong> gejala di bawah yang dipilih siswa)
          </label>
        </div>

        <label class="form-label fw-semibold small mb-2">Pilih Gejala *</label>
        <div class="row g-2" style="max-height:320px;overflow-y:auto">
          @foreach($gejalaList as $g)
          <div class="col-md-6">
            <label class="gejala-check-item w-100">
              <input type="checkbox" name="gejala[]" value="{{ $g->kode }}"
                     {{ in_array($g->kode, old('gejala', $gejalaTerpilih)) ? 'checked' : '' }}>
              <span class="small">
                <span class="badge bg-light text-dark border me-1">{{ $g->kode }}</span>
                {{ $g->nama }}
              </span>
            </label>
          </div>
          @endforeach
        </div>

        <div class="d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-warning px-4">
            <i class="bi bi-save me-1"></i>Perbarui Rule
          </button>
          <a href="{{ route('admin.rules.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection