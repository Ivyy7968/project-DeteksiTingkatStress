<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hasil Diagnosa – {{ $diagnosa->user->name }}</title>
<link rel="stylesheet" href="{{ asset('css/cetak-diagnosa.css') }}">
<link rel="stylesheet" href="{{ asset('css/kop-surat.css') }}">
<style>
  @media screen {
    body { background: #e5e7eb; }
    .page {
      width: 21cm;
      min-height: 29.7cm;
      margin: 0 auto 2rem auto;
      padding: 1cm 1.5cm;
      background: #fff;
      box-shadow: 0 4px 24px rgba(0,0,0,.15);
    }
  }
  @page { size: A4 portrait; margin: 1cm 1.5cm; }
  @media print {
    .no-print { display: none !important; }
    body { background: #fff; }
    .page { width:100%; min-height:auto; margin:0; padding:0; box-shadow:none; }
    .info-grid { page-break-inside: avoid; }
    .gejala-grid { page-break-inside: avoid; }
    .rekomendasi-box { page-break-inside: avoid; }
    .ttd-section { page-break-inside: avoid; }
  }
</style>
</head>
<body>

  {{-- Tombol Aksi --}}
  <div class="no-print" style="display:flex;justify-content:space-between;align-items:center;width:21cm;margin:0 auto;padding:1rem 0 .75rem 0">
    <a href="{{ route('siswa.hasil', $diagnosa->id) }}"style="display:inline-flex;align-items:center;gap:.4rem;padding:.4rem .9rem;border:1px solid #d1d5db;border-radius:.4rem;text-decoration:none;color:#374151;font-size:12px">&larr; Kembali</a>
    <button onclick="window.print()"style="display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1.4rem;background:#4f46e5;border:none;border-radius:.4rem;color:#fff;font-size:12px;cursor:pointer;font-weight:600">Cetak / Simpan PDF</button>
  </div>

  <div class="page">

    {{-- Kop Surat --}}
    <div class="kop">
      <img src="{{ asset('images/logo-smandas.jpg') }}" alt="Logo SMAN 12 Depok" class="kop-logo">
      <div class="kop-text">
        <div class="kop-website">SiDeteksi</div>
        <div class="kop-sekolah">SMA Negeri 12 Depok</div>
        <div class="kop-alamat">
          Jl. Raya Cipayung No.47, Cipayung Jaya, Kec. Cipayung,<br>
          Kota Depok, Jawa Barat 16437
        </div>
      </div>
    </div>
    <hr class="kop-divider-top">
    <hr class="kop-divider-bottom">

    {{-- Judul --}}
    <div class="laporan-judul">
      <div class="judul-text">Hasil Diagnosa Tingkat Stres</div>
    </div>

    {{-- Alert Kritis --}}
    @if(in_array($diagnosa->output_kode, ['S4','S5']))
    <div class="alert-kritis">
      <strong>Perhatian:</strong> Hasil diagnosa menunjukkan tingkat stres yang tinggi.
      Segera hubungi guru BK, psikolog sekolah, atau orang tua/wali untuk mendapatkan bantuan.
    </div>
    @endif

    {{-- Info Grid --}}
    <div class="section-title">Informasi Siswa & Hasil</div>
    <div class="info-grid">
      <div class="info-box">
        <div class="info-row">
          <span class="info-label">Nama Lengkap</span>
          <span class="info-value">{{ $diagnosa->user->name }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">NIS</span>
          <span class="info-value">{{ $diagnosa->user->nis ?? '-' }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Kelas</span>
          <span class="info-value">{{ $diagnosa->user->kelas ?? '-' }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Jenis Kelamin</span>
          <span class="info-value">{{ $diagnosa->user->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Tanggal Diagnosa</span>
          <span class="info-value">{{ $diagnosa->created_at->format('d M Y, H:i') }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Rule yang Cocok</span>
          <span class="info-value">{{ $diagnosa->rule_cocok ?? 'Fallback' }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Jumlah Gejala</span>
          <span class="info-value">{{ count($diagnosa->gejala_dipilih) }} dari 28 indikator</span>
        </div>
      </div>

      <div class="result-box" style="border-color:{{ $diagnosa->output->warna }}40;background:{{ $diagnosa->output->warna }}08">
        <div class="result-label">Tingkat Stres</div>
        <div>
          <span class="result-badge" style="background:{{ $diagnosa->output->warna }}">
            {{ $diagnosa->output->tingkat }}
          </span>
        </div>
        <div class="result-desc">{{ $diagnosa->output->deskripsi }}</div>
      </div>
    </div>

    {{-- Rekomendasi --}}
    <div class="section-title">Rekomendasi Tindakan</div>
    <div class="rekomendasi-box" style="border-left-color:{{ $diagnosa->output->warna }}">
      <p>{{ $diagnosa->output->rekomendasi }}</p>
    </div>

    {{-- Gejala --}}
    <div class="section-title">Gejala yang Terdeteksi ({{ $gejalaDipilih->count() }} dari 28 Indikator)</div>
    <div class="gejala-grid">
      @foreach($gejalaDipilih as $g)
      <div class="gejala-item">
        <span class="gejala-kode">{{ $g->kode }}</span>
        <span class="gejala-nama">{{ $g->nama }}</span>
      </div>
      @endforeach
    </div>

    {{-- Catatan --}}
    <div class="catatan-box">
      <strong>Catatan Penting:</strong> Hasil diagnosa ini bersifat informatif dan tidak menggantikan
      konsultasi dengan tenaga profesional. Jika kamu merasa perlu bantuan lebih lanjut, jangan ragu
      untuk menghubungi guru BK atau psikolog sekolah.
    </div>

    {{-- Tanda Tangan --}}
    <div class="ttd-section">
      <div class="ttd-box">
        <div class="ttd-kota" id="ttdTanggal">Depok, ...</div>
        <div class="ttd-title">Mengetahui,</div>
        <div class="ttd-place">Kepala Sekolah</div>
        <div class="ttd-name">(Dr. Tuti Herawati, M.Pd.)</div>
      </div>
    </div>
  </div>

<script>
  const hari  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
  const bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
  function updateWaktu() {
    const now      = new Date();
    const namaHari = hari[now.getDay()];
    const tgl      = String(now.getDate()).padStart(2, '0');
    const jam      = String(now.getHours()).padStart(2, '0');
    const mnt      = String(now.getMinutes()).padStart(2, '0');
    const dtk      = String(now.getSeconds()).padStart(2, '0');
    document.getElementById('ttdTanggal').textContent =
      `Depok, ${namaHari}, ${tgl} ${bulan[now.getMonth()]} ${now.getFullYear()}`;
  }
  updateWaktu();
  setInterval(updateWaktu, 1000);
</script>
</body>
</html>