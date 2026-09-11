@extends('layouts.app')
@section('title','Edit Gejala')

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
      <h4 class="fw-bold mb-0">Edit Gejala</h4>
      <p class="text-muted small mb-0">{{ $gejala->kode }} &middot; {{ $gejala->nama }}</p>
    </div>
  </div>

  @if($errors->any())
  <div class="alert alert-danger small">
    <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
  @endif

  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.gejala.update', $gejala->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label fw-semibold small">Kode *</label>
            <input type="text" name="kode" class="form-control" value="{{ old('kode', $gejala->kode) }}" required>
          </div>
          <div class="col-md-8">
            <label class="form-label fw-semibold small">Nama / Deskripsi Gejala *</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $gejala->nama) }}" required>
          </div>
        </div>
        <div class="d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-warning px-4">
            <i class="bi bi-save me-1"></i>Perbarui
          </button>
          <a href="{{ route('admin.gejala.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection