<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Daftar Siswa – SiDeteksi</title>
<link rel="stylesheet" href="{{ asset('css/kop-surat.css') }}">
</head>
<body>

  {{-- Tombol Aksi --}}
  <div class="no-print">
    <a href="{{ route('admin.laporan.index', ['tab'=>'siswa']) }}"
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

    {{-- Judul Laporan --}}
    <div class="laporan-judul">
      <div class="judul-text">Laporan Daftar Siswa</div>
      <div class="judul-sub">
        Kelas: {{ $filterKelas }} </span>
      </div>
    </div>

    {{-- Ringkasan --}}
    @php
      $totalSiswa = $siswa->count();
      $sudahTes   = $siswa->filter(fn($s) => $s->diagnosaTerakhir)->count();
      $belumTes   = $totalSiswa - $sudahTes;
    @endphp

    <div class="summary-grid" style="grid-template-columns:repeat(3,1fr)">
      <div class="summary-box">
        <div class="summary-value">{{ $totalSiswa }}</div>
        <div class="summary-label">Total Siswa</div>
      </div>
      <div class="summary-box">
        <div class="summary-value" style="color:#28a745">{{ $sudahTes }}</div>
        <div class="summary-label">Sudah Tes</div>
      </div>
      <div class="summary-box">
        <div class="summary-value" style="color:#dc3545">{{ $belumTes }}</div>
        <div class="summary-label">Belum Tes</div>
      </div>
    </div>

    {{-- Tabel --}}
    <div class="section-title">
      Data Siswa {{ $filterKelas !== 'Semua Kelas' ? '– '.$filterKelas : '' }}
    </div>
    <table>
      <thead>
        <tr>
          <th style="width:30px">No</th>
          <th>Nama Siswa</th>
          <th>NIS</th>
          <th>Kelas</th>
          <th>Jenis Kelamin</th>
          <th>Status</th>
          <th>Tingkat Stres</th>
        </tr>
      </thead>
      <tbody>
        @forelse($siswa as $i => $s)
        <tr>
          <td style="text-align:center">{{ $i + 1 }}</td>
          <td style="font-weight:600">{{ $s->name }}</td>
          <td>{{ $s->nis ?? '-' }}</td>
          <td>{{ $s->kelas ?? '-' }}</td>
          <td>{{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
          <td>
            @if($s->diagnosaTerakhir)
            <span class="badge-status" style="background:#28a745">Sudah Tes</span>
            @else
            <span class="badge-status" style="background:#6c757d">Belum Tes</span>
            @endif
          </td>
          <td>
            @if($s->diagnosaTerakhir && $s->diagnosaTerakhir->output)
            <span class="badge-status" style="background:{{ $s->diagnosaTerakhir->output->warna }}">
              {{ $s->diagnosaTerakhir->output->tingkat }}
            </span>
            @else
            <span style="color:#9ca3af">-</span>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="text-align:center;padding:1rem;color:#9ca3af">
            Tidak ada data siswa.
          </td>
        </tr>
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