<?php

namespace App\Http\Controllers;

use App\Models\Diagnosa;
use App\Models\Gejala;
use App\Models\OutputStres;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSiswa     = User::where('role','siswa')->count();
        $sudahTes       = Diagnosa::distinct('user_id')->count('user_id');
        $belumTes       = $totalSiswa - $sudahTes;
        $rataRata       = $this->hitungRataRata();

        $distribusi = Diagnosa::selectRaw('output_kode, count(*) as total')
            ->groupBy('output_kode')
            ->pluck('total','output_kode');

        $outputList = OutputStres::all()->keyBy('kode');

        $diagnosaRecent = Diagnosa::with(['user','output'])->latest()->take(8)->get();

        // Distribusi rata-rata tingkat stres per kelas
        $distribusiKelas = User::where('role','siswa')
            ->whereNotNull('kelas')
            ->with(['diagnosaTerakhir.output'])
            ->get()
            ->groupBy('kelas')
            ->map(function ($siswaPerKelas) {
                $map        = ['S1'=>1,'S2'=>2,'S3'=>3,'S4'=>4,'S5'=>5];
                $total      = $siswaPerKelas->count();
                $sudahTes   = $siswaPerKelas->filter(fn($s) => $s->diagnosaTerakhir)->count();
                $totalNilai = $siswaPerKelas
                    ->filter(fn($s) => $s->diagnosaTerakhir)
                    ->sum(fn($s) => $map[$s->diagnosaTerakhir->output_kode] ?? 0);
                $rata = $sudahTes > 0 ? round($totalNilai / $sudahTes, 2) : 0;
                return [
                    'total'     => $total,
                    'sudah_tes' => $sudahTes,
                    'rata_rata' => $rata,
                ];
            })
            ->sortKeys();

        return view('admin.dashboard', compact(
            'totalSiswa','sudahTes','belumTes','rataRata',
            'distribusi','outputList','diagnosaRecent','distribusiKelas'
        ));
    }

    // ── CRUD Siswa ───────────────────────────────────────────────
    public function indexSiswa(Request $request)
    {
        $query = User::where('role','siswa')
            ->withCount('diagnosa')
            ->with('diagnosaTerakhir.output');

        if ($request->search) {
            $q = $request->search;
            $query->where(function($builder) use ($q) {
                $builder->where('name','like',"%$q%")
                        ->orWhere('nis','like',"%$q%")
                        ->orWhere('email','like',"%$q%");
            });
        }

        $siswa = $query->paginate(15)->withQueryString();
        return view('admin.siswa.index', compact('siswa'));
    }

    public function createSiswa()
    {
        return view('admin.siswa.create');
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'nis'           => 'required|string|unique:users,nis',
            'kelas'         => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
        ]);

        User::create([
            'name'          => $request->name,
            'nis'           => $request->nis,
            'kelas'         => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => 'siswa',
        ]);

        return redirect()->route('admin.siswa.index')->with('success','Siswa berhasil ditambahkan.');
    }

    public function editSiswa($id)
    {
        $siswa = User::where('role','siswa')->findOrFail($id);
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function updateSiswa(Request $request, $id)
    {
        $siswa = User::where('role','siswa')->findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:100',
            'nis'           => "required|string|unique:users,nis,$id",
            'kelas'         => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'email'         => "required|email|unique:users,email,$id",
        ]);

        $data = $request->only(['name','nis','kelas','jenis_kelamin','email']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $siswa->update($data);
        return redirect()->route('admin.siswa.index')->with('success','Data siswa diperbarui.');
    }

    public function destroySiswa($id)
    {
        User::where('role','siswa')->findOrFail($id)->delete();
        return redirect()->route('admin.siswa.index')->with('success','Siswa dihapus.');
    }

    public function showSiswa($id)
    {
        $siswa   = User::where('role','siswa')->findOrFail($id);
        $riwayat = Diagnosa::with('output')->where('user_id',$id)->latest()->get();
        return view('admin.siswa.show', compact('siswa','riwayat'));
    }

    // ── Cetak Diagnosa ───────────────────────────────────────────
    public function cetakDiagnosa($id)
    {
        $diagnosa      = Diagnosa::with(['user','output'])->findOrFail($id);
        $gejalaDipilih = Gejala::whereIn('kode', $diagnosa->gejala_dipilih)->get();

        return view('admin.cetak-diagnosa', compact('diagnosa','gejalaDipilih'));
    }

    // ── Cetak Semua Siswa ─────────────────────────────────────────
    public function cetakSemuaSiswa(Request $request)
    {
        $query = User::where('role','siswa')
            ->with('diagnosaTerakhir.output')
            ->orderBy('kelas')
            ->orderBy('name');

        if ($request->kelas) {
            $query->where('kelas', $request->kelas);
        }

        $siswa     = $query->get();
        $kelasList = User::where('role','siswa')
            ->whereNotNull('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        return view('admin.cetak-siswa', compact('siswa','kelasList'));
    }

    // ── Helpers ──────────────────────────────────────────────────
    private function hitungRataRata(): string
    {
        $map = ['S1'=>1,'S2'=>2,'S3'=>3,'S4'=>4,'S5'=>5];
        $all = Diagnosa::pluck('output_kode');
        if ($all->isEmpty()) return '-';
        $sum = $all->sum(fn($k) => $map[$k] ?? 0);
        $avg = $sum / $all->count();
        if ($avg < 1.5) return 'Normal';
        if ($avg < 2.5) return 'Ringan';
        if ($avg < 3.5) return 'Sedang';
        if ($avg < 4.5) return 'Berat';
        return 'Sangat Berat';
    }
}