@extends('layouts.app')
@section('title','Edit Data Siswa')

@section('sidebar-menu')
@include('admin.partials.sidebar-menu')
@endsection

@section('content')
<div style="max-width:600px">
  <div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.siswa.index') }}" class="btn btn-sm btn-outline-secondary">
      <i class="bi bi-arrow-left"></i>
    </a>
    <div>
      <h4 class="fw-700 mb-0">Edit Data Siswa</h4>
      <p class="text-muted small mb-0">{{ $siswa->name }}</p>
    </div>
  </div>

  @if($errors->any())
  <div class="alert alert-danger small">
    <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{$e}}</li>@endforeach</ul>
  </div>
  @endif

  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
          <div class="col-12">
            <label class="form-label fw-500 small">Nama Lengkap *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name',$siswa->name) }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-500 small">NIS *</label>
            <input type="text" name="nis" class="form-control" value="{{ old('nis',$siswa->nis) }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-500 small">Kelas *</label>
            <select name="kelas" class="form-select" required>
              @foreach(['X IPA 1','X IPA 2','X IPA 3','X IPS 1','X IPS 2','X IPS 3','XI IPA 1','XI IPA 2','X IPA 3','XI IPS 1','XI IPS 2','XI IPS 3','XII IPA 1','XII IPA 2','XII IPA 3','XII IPS 1','XII IPS 2','XII IPS 3'] as $k)
              <option value="{{$k}}" {{ (old('kelas',$siswa->kelas))===$k?'selected':'' }}>{{$k}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-500 small">Jenis Kelamin *</label>
            <select name="jenis_kelamin" class="form-select" required>
              <option value="L" {{ old('jenis_kelamin',$siswa->jenis_kelamin)==='L'?'selected':'' }}>Laki-laki</option>
              <option value="P" {{ old('jenis_kelamin',$siswa->jenis_kelamin)==='P'?'selected':'' }}>Perempuan</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-500 small">Email *</label>
            <input type="email" name="email" class="form-control" value="{{ old('email',$siswa->email) }}" required>
          </div>
          <div class="col-12">
            <label class="form-label fw-500 small">Password Baru <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
            <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter">
          </div>
        </div>
        <div class="d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-warning px-4">
            <i class="bi bi-save me-1"></i>Perbarui
          </button>
          <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection