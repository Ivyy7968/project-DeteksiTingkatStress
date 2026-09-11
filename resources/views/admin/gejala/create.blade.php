@extends('layouts.app')
@section('title','Tambah Gejala')

@section('sidebar-menu')
@include('admin.partials.sidebar-menu')
@endsection

@section('content')
<div style="max-width:600px">
  <div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.gejala.index') }}" class="btn btn-sm btn-outline-secondary">
      <i class="bi bi-arrow-left"></i>
    </a>
    <div>
      <h4 class="fw-bold mb-0">Tambah Gejala Baru</h4>
      <p class="text-muted small mb-0">Gejala baru tidak otomatis aktif di rule manapun</p>
    </div>
  </div>

  @if($errors->any())
  <div class="alert alert-danger small">
    <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
  @endif

  <div class="alert alert-info small d-flex gap-2">
    <i class="bi bi-info-circle-fill mt-1"></i>
    <div>Setelah gejala ini ditambahkan, kunjungi menu <strong>Data Aturan</strong> untuk memasukkannya ke dalam satu atau lebih rule agar berpengaruh terhadap hasil diagnosa.</div>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.gejala.store') }}" method="POST">
        @csrf
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label fw-semibold small">Kode *</label>
            <input type="text" name="kode" class="form-control" value="{{ old('kode', $kodeBerikutnya) }}" placeholder="G29" required>
            <div class="form-text">Format: G diikuti angka, contoh G29</div>
          </div>
          <div class="col-md-8">
            <label class="form-label fw-semibold small">Nama / Deskripsi Gejala *</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Contoh: Sering merasa kesepian meski berada di tengah keramaian" required>
          </div>
        </div>
        <div class="d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-check-lg me-1"></i>Simpan Gejala
          </button>
          <a href="{{ route('admin.gejala.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection