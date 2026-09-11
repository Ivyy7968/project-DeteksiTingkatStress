<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Siswa – SiDeteksi</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="{{ asset('css/login-siswa.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="auth-card mx-auto">

        <a href="{{ route('landing') }}" class="text-decoration-none">
          <p class="auth-brand mb-1"><i class="bi bi-brain me-1"></i>SiDeteksi</p>
        </a>
        <h4 class="fw-bold mb-1">Login Siswa</h4>
        <p class="text-muted small mb-4">Masuk untuk memulai diagnosa tingkat stres</p>

        {{-- Pesan Error --}}
        @if($errors->any())
        <div class="alert alert-danger d-flex align-items-start gap-2 py-2 small" role="alert">
          <i class="bi bi-exclamation-triangle-fill mt-1 flex-shrink-0"></i>
          <div>
            @foreach($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        </div>
        @endif

        {{-- Pesan Sukses --}}
        @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 py-2 small" role="alert">
          <i class="bi bi-check-circle-fill flex-shrink-0"></i>
          <div>{{ session('success') }}</div>
        </div>
        @endif

        <form action="{{ route('login.siswa') }}" method="POST" novalidate>
          @csrf

          <div class="mb-3">
            <label class="form-label fw-semibold small">Email</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0">
                <i class="bi bi-envelope text-muted"></i>
              </span>
              <input type="email" name="email"class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"placeholder="email@smandas.sch.id"value="{{ old('email') }}"autocomplete="email"required>
              @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Password</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0">
                <i class="bi bi-lock text-muted"></i>
              </span>
              <input type="password" name="password" id="pwd"class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror"placeholder="••••••••"autocomplete="current-password"required>
              <button type="button" class="input-group-text bg-light" onclick="togglePwd()">
                <i class="bi bi-eye" id="eyeIcon"></i>
              </button>
              @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label small text-muted" for="remember">Ingat saya</label>
          </div>

          <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
          </button>
        </form>

        <hr class="my-4">
        <p class="text-center text-muted small mb-2">Belum punya akun?<a href="{{ route('register') }}" class="text-primary fw-semibold">Daftar di sini</a>
        </p>
        <p class="text-center mb-0">
          <a href="{{ route('login.admin') }}" class="text-muted small">
            <i class="bi bi-shield me-1"></i>Login sebagai Admin
          </a>
        </p>

      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
function togglePwd() {
  const p = document.getElementById('pwd');
  const e = document.getElementById('eyeIcon');
  p.type = p.type === 'password' ? 'text' : 'password';
  e.className = p.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
</body>
</html>