<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Siswa – SiDeteksi</title>
<link rel="stylesheet" href="{{ asset('css/cetak-siswa.css') }}">
</head>
<body>

  {{-- Tombol Aksi --}}
  <div class="no-print">
    <div class="d-flex align-items-center gap-3">
      <a href="{{ route('admin.siswa.index') }}"
         style="display:inline-flex;align-items:center;gap:.4rem;padding:.4rem .9rem;border:1px solid #d1d5db;border-radius:.4rem;text-decoration:none;color:#374151;font-size:12px">
        &larr; Kembali
      </a>

      {{-- Filter Kelas --}}
      <form method="GET" action="{{ route('admin.siswa.cetak') }}"
            style="display:flex;align-items:center;gap:.5rem">
        <label style="font-size:12px;color:#374151;font-weight:600">Filter Kelas:</label>
        <select name="kelas" onchange="this.form.submit()"
                style="font-size:12px;padding:.3rem .6rem;border:1px solid #d1d5db;border-radius:.35rem">
          <option value="">Semua Kelas</option>
          @foreach($kelasList as $k)
          <option value="{{ $k }}" {{ request('kelas') === $k ? 'selected' : '' }}>{{ $k }}</option>
          @endforeach
        </select>
      </form>
    </div>

    <button onclick="window.print()"
            style="display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1.4rem;background:#4f46e5;border:none;border-radius:.4rem;color:#fff;font-size:12px;cursor:pointer;font-weight:600">
      Cetak
    </button>
  </div>

  <div class="page">

    {{-- Header --}}
    <div class="header">
      <div class="header-left">
        <div class="brand">Si<span>Deteksi</span></div>
        <div class="subtitle">Deteksi Tingkat Stres Siswa | SMA Negeri 12 Depok</div>
      </div>
      <div class="header-right">
        <div class="doc-title">Daftar Siswa</div>
        <div class="doc-date" id="waktuCetak">Dicetak: ...</div>
      </div>
    </div>

    {{-- Ringkasan --}}
    @php
      $totalSiswa   = $siswa->count();
      $sudahTes     = $siswa->filter(fn($s) => $s->diagnosaTerakhir)->count();
      $belumTes     = $totalSiswa - $sudahTes;
      $filterKelas  = request('kelas') ? request('kelas') : 'Semua Kelas';
    @endphp

    <div class="summary-grid">
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
      <div class="summary-box">
        <div class="summary-value" style="font-size:1rem">{{ $filterKelas }}</div>
        <div class="summary-label">Filter Kelas</div>
      </div>
    </div>

    {{-- Tabel --}}
    <div class="section-title">Data Siswa {{ $filterKelas !== 'Semua Kelas' ? '– '.$filterKelas : '' }}</div>
    <table>
      <thead>
        <tr>
          <th style="width:30px">No</th>
          <th>Nama Siswa</th>
          <th>NIS</th>
          <th>Kelas</th>
          <th>Jenis Kelamin</th>
          <th>Email</th>
          <th>Status Diagnosa</th>
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
          <td style="color:#6b7280">{{ $s->email }}</td>
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
          <td colspan="8" style="text-align:center;padding:1rem;color:#9ca3af">
            Tidak ada data siswa.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>


<script>
  const hari  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
  const bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

  function updateWaktu() {
    const now       = new Date();
    const namaHari  = hari[now.getDay()];
    const tgl       = String(now.getDate()).padStart(2, '0');
    const namaBulan = bulan[now.getMonth()];
    const tahun     = now.getFullYear();
    const jam       = String(now.getHours()).padStart(2, '0');
    const menit     = String(now.getMinutes()).padStart(2, '0');
    const detik     = String(now.getSeconds()).padStart(2, '0');
    const bln       = String(now.getMonth() + 1).padStart(2, '0');

    document.getElementById('waktuCetak').textContent =
      `Dicetak: ${namaHari}, ${tgl} ${namaBulan} ${tahun}, ${jam}:${menit} WIB`;
  }

  updateWaktu();
  setInterval(updateWaktu, 1000);
</script>

</body>
</html>