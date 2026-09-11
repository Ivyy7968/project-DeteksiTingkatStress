<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Data Aturan – SiDeteksi</title>
<link rel="stylesheet" href="{{ asset('css/kop-surat.css') }}">
<style>
  .rule-gejala-badge {
    display: inline-block;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: .25rem;
    padding: .05rem .35rem;
    font-size: 9px;
    margin: 0 .1rem;
  }
  .rule-negasi-tag {
    display: inline-block;
    background: #fef9c3;
    color: #92400e;
    border-radius: .25rem;
    padding: .05rem .35rem;
    font-size: 8.5px;
    font-weight: 700;
    margin-right: .3rem;
  }
</style>
</head>
<body>
  <div class="no-print">
    <a href="{{ route('admin.laporan.index', ['tab'=>'aturan']) }}"
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
      <div class="judul-text">Laporan Data Aturan (Rules)</div>
    </div>

    {{-- Ringkasan --}}
    <div class="summary-grid" style="display:flex;justify-content:center">
      <div class="summary-box" style="width:220px">
        <div class="summary-value">{{ $rules->count() }}</div>
        <div class="summary-label">Total Rule</div>
      </div>
    </div>

    {{-- Tabel --}}
    <div class="section-title">Daftar Rule</div>
    <table>
      <thead>
        <tr>
          <th style="width:30px">No</th>
          <th style="width:60px">Kode</th>
          <th>Kondisi Gejala</th>
          <th style="width:130px">Hasil</th>
        </tr>
      </thead>
      <tbody>
        @forelse($rules as $i => $r)
        <tr>
          <td style="text-align:center">{{ $i + 1 }}</td>
          <td><span class="badge-status" style="background:#4f46e5">{{ $r->kode }}</span></td>
          <td>
            @if($r->isNegasi())
            <span class="rule-negasi-tag">TIDAK ADA</span>
            @endif
            @foreach($r->gejalaKode() as $j => $kg)
              @if($j > 0)
              <span style="color:#9ca3af;font-size:9px"> {{ $r->isNegasi() ? 'maupun' : 'DAN' }} </span>
              @endif
              <span class="rule-gejala-badge">{{ $kg }}</span>
            @endforeach
          </td>
          <td>
            <span class="badge-status" style="background:{{ $r->output->warna ?? '#6c757d' }}">
              {{ $r->output->tingkat ?? $r->output_kode }}
            </span>
          </td>
        </tr>
        @empty
        <tr><td colspan="4" style="text-align:center;padding:1rem;color:#9ca3af">Tidak ada data rule.</td></tr>
        @endforelse
      </tbody>
    </table>

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