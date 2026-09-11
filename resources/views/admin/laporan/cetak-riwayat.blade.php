<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Riwayat Diagnosa – SiDeteksi</title>
<link rel="stylesheet" href="{{ asset('css/kop-surat.css') }}">
</head>
<body>
  <div class="no-print">
    <a href="{{ route('admin.laporan.index', ['tab'=>'riwayat']) }}"
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
      <div class="judul-text">Laporan Riwayat Diagnosa</div>
    </div>

    {{-- Ringkasan --}}
    <div class="summary-grid" style="grid-template-columns:repeat(3,1fr)">
      <div class="summary-box">
        <div class="summary-value">{{ $riwayat->count() }}</div>
        <div class="summary-label">Total Diagnosa</div>
      </div>
      <div class="summary-box">
        <div class="summary-value" style="color:#28a745">{{ $riwayat->pluck('user_id')->unique()->count() }}</div>
        <div class="summary-label">Siswa</div>
      </div>
      <div class="summary-box">
        <div class="summary-value" style="color:#dc3545">{{ $riwayat->whereIn('output_kode', ['S4','S5'])->count() }}</div>
        <div class="summary-label">Berisiko Tinggi</div>
      </div>
    </div>

    {{-- Tabel --}}
    <div class="section-title">Rekap Riwayat Diagnosa ({{ $riwayat->count() }} data)</div>
    <table>
      <thead>
        <tr>
          <th style="width:30px">No</th>
          <th>Nama Siswa</th>
          <th>NIS</th>
          <th>Kelas</th>
          <th>Tingkat Stres</th>
          <th>Jml Gejala</th>
          <th>Rule</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        @forelse($riwayat as $i => $d)
        <tr>
          <td style="text-align:center">{{ $i + 1 }}</td>
          <td style="font-weight:600">{{ $d->user->name }}</td>
          <td>{{ $d->user->nis ?? '-' }}</td>
          <td>{{ $d->user->kelas ?? '-' }}</td>
          <td><span class="badge-status" style="background:{{ $d->output->warna }}">{{ $d->output->tingkat }}</span></td>
          <td style="text-align:center">{{ count($d->gejala_dipilih) }}</td>
          <td>{{ $d->rule_cocok ?? '-' }}</td>
          <td>{{ $d->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;padding:1rem;color:#9ca3af">Tidak ada riwayat diagnosa.</td></tr>
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