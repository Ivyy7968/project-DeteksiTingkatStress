<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Data Output – SiDeteksi</title>
<link rel="stylesheet" href="{{ asset('css/kop-surat.css') }}">
<style>
  .output-card {
    border: 1px solid #e5e7eb;
    border-radius: .5rem;
    padding: .85rem 1rem;
    margin-bottom: .75rem;
    border-left: 4px solid;
  }
  .output-card .oc-title { font-size: 12px; font-weight: 700; margin-bottom: .3rem; }
  .output-card .oc-desc { font-size: 10px; color: #4b5563; line-height: 1.6; margin-bottom: .4rem; }
  .output-card .oc-rekom { font-size: 10px; color: #374151; line-height: 1.6; }
  .output-card .oc-rekom strong { color: #1a1a2e; }
</style>
</head>
<body>
  <div class="no-print">
    <a href="{{ route('admin.laporan.index', ['tab'=>'output']) }}"
       style="display:inline-flex;align-items:center;gap:.4rem;padding:.4rem .9rem;border:1px solid #d1d5db;border-radius:.4rem;text-decoration:none;color:#374151;font-size:12px">
      &larr; Kembali
    </a>
    <button onclick="window.print()"
            style="display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1.4rem;background:#4f46e5;border:none;border-radius:.4rem;color:#fff;font-size:12px;cursor:pointer;font-weight:600">
      Cetak
    </button>
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
      <div class="judul-text">Laporan Data Diagnosa (Tingkat Stres)</div>
    </div>

    {{-- Ringkasan --}}
    <div class="summary-grid" style="display:flex;justify-content:center">
      <div class="summary-box" style="width:220px">
        <div class="summary-value">{{ $outputList->count() }}</div>
        <div class="summary-label">Total Tingkat Stres</div>
      </div>
    </div>

    {{-- Data Output --}}
    <div class="section-title">Daftar Tingkat Stres (Output)</div>
    @foreach($outputList as $o)
    <div class="output-card" style="border-left-color:{{ $o->warna }}">
      <div class="oc-title" style="color:{{ $o->warna }}">{{ $o->kode }} &mdash; {{ $o->tingkat }}</div>
      <div class="oc-desc">{{ $o->deskripsi }}</div>
      <div class="oc-rekom"><strong>Rekomendasi:</strong> {{ $o->rekomendasi }}</div>
    </div>
    @endforeach

    {{-- Tanda Tangan --}}
    <div class="ttd-section">
      <div class="ttd-box">
        <div class="ttd-kota" id="ttdTanggal">Depok, ...</div>
        <div class="ttd-title">Mengetahui,</div>
        <div class="ttd-place">Kepala Sekolah</div>
        <div></div>
        <div class="ttd-name">( Dr. Tuti Herawati, M.Pd. )</div>
      </div>
    </div>

  </div>

<script>
  const hari  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
  const bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
  function updateWaktu() {
    const now      = new Date();
    const namaHari = hari[now.getDay()];
    const tgl      = String(now.getDate()).padStart(2,'0');
    const jam      = String(now.getHours()).padStart(2,'0');
    const mnt      = String(now.getMinutes()).padStart(2,'0');
    const dtk      = String(now.getSeconds()).padStart(2,'0');
    document.getElementById('ttdTanggal').textContent =
      `Depok, ${namaHari}, ${tgl} ${bulan[now.getMonth()]} ${now.getFullYear()}`;
  }
  updateWaktu();
  setInterval(updateWaktu, 1000);
</script>
</body>
</html>