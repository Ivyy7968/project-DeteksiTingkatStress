<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin – SiDeteksi</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="{{ asset('css/login-admin.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="auth-card mx-auto">

        <div class="text-center mb-4">
          <div class="d-inline-flex align-items-center justify-content-center bg-dark rounded-circle mb-3"style="width:56px;height:56px">
            <i class="bi bi-shield-lock text-white fs-4"></i>
          </div>
          <h4 class="fw-bold mb-1">Portal Admin</h4>
          <p class="text-muted small">SiDeteksi – Akses Administrator</p>
        </div>

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

        <form action="{{ route('login.admin') }}" method="POST" novalidate>
          @csrf
          <div class="mb-3">
            <label class="form-label fw-semibold small">Email Admin</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0">
                <i class="bi bi-envelope text-muted"></i>
              </span>
              <input type="email" name="email"class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"placeholder="admin@smandas.sch.id"value="{{ old('email') }}"autocomplete="email"required>
              @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mb-4">
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

          <button type="submit" class="btn btn-dark w-100 py-2 fw-semibold">
            <i class="bi bi-shield-check me-1"></i>Masuk sebagai Admin
          </button>
        </form>

        <p class="text-center mt-4 mb-0">
          <a href="{{ route('landing') }}" class="text-muted small">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
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