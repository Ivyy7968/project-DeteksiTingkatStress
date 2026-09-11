<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Siswa – SiDeteksi</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="{{ asset('css/register.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
      <div class="auth-card mx-auto">

        <a href="{{ route('landing') }}" class="text-decoration-none">
          <p class="mb-1 fw-bold fs-5 text-primary"><i class="bi bi-brain me-1"></i>SiDeteksi</p>
        </a>
        <h4 class="fw-bold mb-1">Daftar Akun Siswa</h4>
        <p class="text-muted small mb-4">Isi data diri untuk membuat akun baru</p>

        @if($errors->any())
        <div class="alert alert-danger d-flex align-items-start gap-2 py-2 small" role="alert">
          <i class="bi bi-exclamation-triangle-fill mt-1 flex-shrink-0"></i>
          <div>
            @foreach($errors->all() as $e)
              <div>{{ $e }}</div>
            @endforeach
          </div>
        </div>
        @endif

        <form action="{{ route('register') }}" method="POST" novalidate>
          @csrf
          <div class="row g-3">

            <div class="col-12">
              <label class="form-label fw-semibold small">Nama Lengkap</label>
              <input type="text" name="name"class="form-control @error('name') is-invalid @enderror"placeholder="Nama lengkap"value="{{ old('name') }}"required>
              @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold small">NIS</label>
              <input type="text" name="nis"class="form-control @error('nis') is-invalid @enderror"placeholder="Nomor Induk Siswa"value="{{ old('nis') }}"required>
              @error('nis')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold small">Kelas</label>
              <select name="kelas" class="form-select @error('kelas') is-invalid @enderror" required>
                <option value="">Pilih kelas</option>
                @foreach(['X IPA 1','X IPA 2', 'X IPA 3', 'X IPS 1','X IPS 2', 'X IPS 3', 'XI IPA 1','XI IPA 2', 'XI IPA 3','XI IPS 1','XI IPS 2', 'XI IPS 3','XII IPA 1','XII IPA 2', 'XII IPA 3','XII IPS 1','XII IPS 2', 'XII IPS 3',] as $k)
                <option value="{{ $k }}" {{ old('kelas') === $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
              </select>
              @error('kelas')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold small">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                <option value="">Pilih</option>
                <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
              </select>
              @error('jenis_kelamin')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold small">Email</label>
              <input type="email" name="email"class="form-control @error('email') is-invalid @enderror"placeholder="email@smandas.sch.id"value="{{ old('email') }}"autocomplete="email"required>
              @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold small">Password</label>
              <div class="input-group">
                <input type="password" name="password" id="pwd"class="form-control @error('password') is-invalid @enderror"placeholder="Min. 6 karakter"required>
                <button type="button" class="input-group-text bg-light" onclick="togglePwd('pwd','eyePwd')">
                  <i class="bi bi-eye" id="eyePwd"></i>
                </button>
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold small">Konfirmasi Password</label>
              <div class="input-group">
                <input type="password" name="password_confirmation" id="pwdConfirm"class="form-control"placeholder="Ulangi password"required>
                <button type="button" class="input-group-text bg-light" onclick="togglePwd('pwdConfirm','eyeConfirm')">
                  <i class="bi bi-eye" id="eyeConfirm"></i>
                </button>
              </div>
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                <i class="bi bi-person-check me-1"></i>Daftar Sekarang
              </button>
            </div>

          </div>
        </form>

        <hr class="my-3">
        <p class="text-center text-muted small mb-0">Sudah punya akun?<a href="{{ route('login.siswa') }}" class="text-primary fw-semibold">Login di sini</a>
        </p>

      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
function togglePwd(inputId, iconId) {
  const p = document.getElementById(inputId);
  const e = document.getElementById(iconId);
  p.type = p.type === 'password' ? 'text' : 'password';
  e.className = p.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
</body>
</html>