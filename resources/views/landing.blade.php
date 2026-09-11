<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SiDeteksi – Sistem Deteksi Tingkat Stres Siswa</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="{{ asset('css/landing.css') }}" rel="stylesheet">
</head>
<body>

<!-- ═══ HERO ════════════════════════════════════════════════════ -->
<div class="hero text-white">
  <nav class="navbar navbar-expand-lg navbar-custom container">
    <a class="navbar-brand" href="#">
      <i class="bi bi-brain me-2"></i>SiDeteksi
    </a>

    <!-- Hamburger Mobile -->
    <button class="navbar-toggler" type="button"data-bs-toggle="collapse" data-bs-target="#navMenu"aria-controls="navMenu" aria-expanded="false">
      <i class="bi bi-list text-white fs-5"></i>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <!-- Menu Tengah -->
      <ul class="navbar-nav mx-auto gap-lg-1 mt-2 mt-lg-0">
        <li class="nav-item">
          <a href="#profil" class="nav-menu-link d-block">About</a>
        </li>
        <li class="nav-item">
          <a href="#tingkat-stres" class="nav-menu-link d-block">Tingkat Stres</a>
        </li>
        <li class="nav-item">
          <a href="#cara-pakai" class="nav-menu-link d-block">Panduan</a>
        </li>
      </ul>

      <!-- Tombol Login -->
      <div class="d-flex flex-column flex-lg-row gap-2 mt-3 mt-lg-0">
        <a href="{{ route('login.admin') }}" class="btn-nav">Login Admin</a>
        <a href="{{ route('login.siswa') }}" class="btn-nav btn-nav-primary">Login Siswa</a>
      </div>
    </div>
  </nav>

  <!-- Hero Content -->
  <div class="container flex-grow-1 d-flex align-items-center py-5">
    <div class="row align-items-center g-5 w-100">
      <div class="col-lg-6 hero-text">
        <span class="hero-badge mb-3"><i class="bi bi-cpu me-1"></i>Sistem Pakar · Forward Chaining</span>
        <h1 class="mt-2 mb-3">Deteksi Tingkat Stres Siswa Secara Cerdas</h1>
        <p class="text-white-50 fs-5 mb-4">
          SiDeteksi menggunakan kecerdasan buatan berbasis forward chaining
          untuk menganalisis gejala dan memberikan rekomendasi penanganan yang tepat.
        </p>
        <div class="d-flex flex-wrap gap-3">
          <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4 fw-semibold text-primary">
            <i class="bi bi-person-plus me-2"></i>Mulai Sekarang
          </a>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="hero-image-wrap">
          <img src="{{ asset('images/ilustrasi.png') }}" alt="Ilustrasi siswa stres belajar" class="img-fluid hero-illustration">
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ═══ PROFIL SISTEM ════════════════════════════════════════════ -->
<section class="py-5 bg-white" id="profil">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="badge bg-primary-subtle text-primary mb-2">Profil Sistem</span>
        <h2 class="section-title mb-3">Apa itu SiDeteksi?</h2>
        <p class="text-muted">
          SiDeteksi adalah sistem pakar berbasis <strong>metode Forward Chaining</strong> yang dirancang
          khusus untuk membantu sekolah mendeteksi tingkat stres psikologis pada siswa.
          Sistem ini menggunakan 28 indikator gejala dan 30 aturan pakar yang dikembangkan bersama
          pakar psikologi pendidikan.
        </p>
        <ul class="list-unstyled mt-3">
          <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Analisis otomatis berbasis rule</li>
          <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Rekomendasi tindakan yang tepat</li>
          <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Dashboard monitoring untuk guru/admin</li>
          <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Riwayat diagnosa tersimpan aman</li>
        </ul>
      </div>
      <div class="col-lg-6">
        <div class="row g-3">
          <div class="col-6">
            <div class="p-3 rounded-3 text-center" style="background:#ede9fe">
              <div class="feature-icon mx-auto mb-2" style="background:#ddd6fe">
                <i class="bi bi-cpu text-primary fs-4"></i>
              </div>
              <p class="fw-semibold mb-0 small">Forward Chaining</p>
              <p class="text-muted" style="font-size:.78rem">Inferensi maju dari fakta ke kesimpulan</p>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 rounded-3 text-center" style="background:#ecfdf5">
              <div class="feature-icon mx-auto mb-2" style="background:#d1fae5">
                <i class="bi bi-shield-check text-success fs-4"></i>
              </div>
              <p class="fw-semibold mb-0 small">Terpercaya</p>
              <p class="text-muted" style="font-size:.78rem">Rule dari pakar psikologi pendidikan</p>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 rounded-3 text-center" style="background:#fef3c7">
              <div class="feature-icon mx-auto mb-2" style="background:#fde68a">
                <i class="bi bi-graph-up text-warning fs-4"></i>
              </div>
              <p class="fw-semibold mb-0 small">Monitoring</p>
              <p class="text-muted" style="font-size:.78rem">Pantau kondisi siswa secara berkala</p>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 rounded-3 text-center" style="background:#fee2e2">
              <div class="feature-icon mx-auto mb-2" style="background:#fecaca">
                <i class="bi bi-heart-pulse text-danger fs-4"></i>
              </div>
              <p class="fw-semibold mb-0 small">Peduli Kesehatan</p>
              <p class="text-muted" style="font-size:.78rem">Prioritas kesehatan mental siswa</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══ TINGKAT STRES ═════════════════════════════════════════════ -->
<section class="py-5" style="background:#f8f9fc" id="tingkat-stres">
  <div class="container">
    <div class="text-center mb-5">
      <span class="badge bg-warning-subtle text-warning mb-2">Panduan Tingkat Stres</span>
      <h2 class="section-title">5 Tingkat Stres yang Dideteksi</h2>
      <p class="text-muted">Sistem mengklasifikasikan tingkat stres ke dalam 5 kategori berikut</p>
    </div>
    <div class="row g-3">
      @php
      $levels = [
        ['color'=>'#28a745','label'=>'Normal',
         'desc'=>'Kondisi psikologis sehat. Gejala stres masih dalam batas wajar dan dapat dikelola mandiri.'],
        ['color'=>'#17a2b8','label'=>'Stres Ringan',
         'desc'=>'Tekanan psikologis ringan. Beberapa gejala mulai muncul namun tidak mengganggu fungsi sehari-hari.'],
        ['color'=>'#ffc107','label'=>'Stres Sedang',
         'desc'=>'Gejala fisik dan emosional cukup mengganggu aktivitas belajar dan hubungan sosial.'],
        ['color'=>'#fd7e14','label'=>'Stres Berat',
         'desc'=>'Stres tinggi berdampak nyata pada performa akademik, fisik, dan mental. Butuh intervensi.'],
        ['color'=>'#dc3545','label'=>'Stres Kritis',
         'desc'=>'Krisis psikologis serius yang mengganggu seluruh aspek kehidupan. Butuh penanganan segera.'],
      ];
      @endphp
      @foreach($levels as $l)
      <div class="col-md-4 col-lg">
        <div class="stress-card h-100" style="border-color:{{ $l['color'] }}">
          <div class="d-flex align-items-center gap-2 mb-2">
            <div class="rounded-circle" style="width:10px;height:10px;background:{{ $l['color'] }};flex-shrink:0"></div>
            <strong style="color:{{ $l['color'] }}">{{ $l['label'] }}</strong>
          </div>
          <p class="text-muted small mb-0">{{ $l['desc'] }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- ═══ CARA PAKAI ════════════════════════════════════════════════ -->
<section class="py-5 bg-white" id="cara-pakai">
  <div class="container">
    <div class="text-center mb-5">
      <span class="badge bg-success-subtle text-success mb-2">Panduan</span>
      <h2 class="section-title">Cara Menggunakan SiDeteksi</h2>
      <p class="text-muted">Ikuti langkah-langkah berikut untuk memulai diagnosa</p>
    </div>
    <div class="row g-4">
      @php
      $steps = [
        ['icon'=>'bi-person-plus','title'=>'Daftar / Login','desc'=>'Buat akun siswa menggunakan NIS dan email, atau login jika sudah terdaftar.'],
        ['icon'=>'bi-card-checklist','title'=>'Jawab Pertanyaan','desc'=>'Jawab pertanyaan seputar gejala yang kamu rasakan satu per satu secara jujur.'],
        ['icon'=>'bi-cpu','title'=>'Analisis Sistem Pakar','desc'=>'Sistem pakar menganalisis jawabanmu menggunakan metode forward chaining otomatis.'],
        ['icon'=>'bi-file-earmark-medical','title'=>'Lihat Hasil','desc'=>'Dapatkan hasil diagnosa lengkap dengan tingkat stres dan rekomendasi tindakan.'],
      ];
      @endphp
      @foreach($steps as $i => $s)
      <div class="col-md-6 col-lg-3">
        <div class="d-flex gap-3 align-items-start">
          <div class="step-num">{{ $i + 1 }}</div>
          <div>
            <h6 class="fw-bold mb-1"><i class="bi {{ $s['icon'] }} me-1"></i>{{ $s['title'] }}</h6>
            <p class="text-muted small mb-0">{{ $s['desc'] }}</p>
          </div>
        </div>
       </div>
      @endforeach
    </div>
  </div>
</section>

<!-- ═══ CTA ═══════════════════════════════════════════════════════ -->
<section class="py-5 text-white text-center" style="background:linear-gradient(135deg,#4f46e5,#7c3aed)">
  <div class="container">
    <h2 class="fw-bold mb-3">Siap Mengetahui Tingkat Stresmu?</h2>
    <p class="text-white-50 mb-0">
      Gratis, aman, dan hanya butuh beberapa menit.
    </p>
  </div>
</section>

<!-- ═══ FOOTER ════════════════════════════════════════════════════ -->
<footer class="py-4">
  <div class="container text-center">
    <p class="mb-0 small">
      <i class="bi bi-brain me-1"></i>
      <strong>SiDeteksi</strong> &middot; Sistem Pakar Deteksi Stres Siswa &middot; &copy; {{ date('Y') }}
    </p>
  </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
  // Smooth scroll & tutup navbar saat klik menu
  document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth' });
        const navMenu = document.getElementById('navMenu');
        if (navMenu.classList.contains('show')) {
          bootstrap.Collapse.getInstance(navMenu)?.hide();
        }
      }
    });
  });

  // Highlight menu aktif saat scroll
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-menu-link');

  window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(section => {
      if (window.scrollY >= section.offsetTop - 100) {
        current = section.getAttribute('id');
      }
    });
    navLinks.forEach(link => {
      link.style.background = '';
      link.style.color = 'rgba(255,255,255,.8)';
      if (link.getAttribute('href') === '#' + current) {
        link.style.background = 'rgba(255,255,255,.15)';
        link.style.color = '#fff';
      }
    });
  });
</script>

</body>
</html>