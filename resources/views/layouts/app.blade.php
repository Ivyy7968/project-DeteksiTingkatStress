<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'SiDeteksi – Sistem Deteksi Stres Siswa')</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @stack('styles')
</head>
<body>

<!-- Overlay -->
<div id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- Sidebar -->
<nav class="sidebar" id="sidebar">
  <div class="brand">
    <h5><i class="bi bi-brain me-2"></i>SiDeteksi</h5>
    <small>Sistem Deteksi Stres Siswa</small>
  </div>
  <ul class="nav flex-column mt-3">
    @yield('sidebar-menu')
    <li class="nav-item mt-auto" style="position:absolute;bottom:1rem;width:100%">
      <button type="button" class="nav-link border-0 bg-transparent w-100 text-start text-danger"data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="bi bi-box-arrow-left"></i> Logout</button>
    </li>
  </ul>
</nav>

<!-- Topbar -->
<div class="topbar">
  <button class="btn btn-sm d-md-none" onclick="toggleSidebar()">
    <i class="bi bi-list fs-5" id="toggleIcon"></i>
  </button>
  <div></div>
  <div class="d-flex align-items-center gap-2">
    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
         style="width:35px;height:35px;font-size:.85rem;font-weight:600">
      {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
    </div>
    <span class="d-none d-sm-inline text-muted small">{{ Auth::user()->name }}</span>
  </div>
</div>

<!-- Content -->
<div class="main-content">
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @yield('content')
</div>

<!-- Modal Konfirmasi Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:1rem;border:none">
      <div class="modal-body text-center p-4">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
             style="width:60px;height:60px;background:#fee2e2">
          <i class="bi bi-box-arrow-left text-danger fs-3"></i>
        </div>
        <h5 class="fw-bold mb-2">Keluar dari akun?</h5>
        <p class="text-muted small mb-4">
          Kamu akan keluar dari sesi ini. Pastikan semua pekerjaanmu sudah tersimpan.
        </p>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-outline-secondary w-50" data-bs-dismiss="modal">
            Batal
          </button>
          <form action="{{ route('logout') }}" method="POST" class="w-50">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
              <i class="bi bi-box-arrow-left me-1"></i>Ya, Keluar
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const isOpen  = sidebar.classList.contains('show');
    if (isOpen) {
      closeSidebar();
    } else {
      sidebar.classList.add('show');
      overlay.style.display = 'block';
      document.body.style.overflow = 'hidden';
    }
  }

  function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.remove('show');
    overlay.style.display = 'none';
    document.body.style.overflow = '';
  }

  window.addEventListener('resize', function () {
    if (window.innerWidth >= 768) {
      closeSidebar();
    }
  });
</script>

</body>
</html>