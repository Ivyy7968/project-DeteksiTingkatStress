<?php
// app/Http/Controllers/LaporanController.php
namespace App\Http\Controllers;

use App\Models\Diagnosa;
use App\Models\Gejala;
use App\Models\OutputStres;
use App\Models\Rule;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request) {
        $tab = $request->get('tab', 'siswa');

        $siswa           = null;
        $riwayatDiagnosa = null;
        $gejala          = null;
        $outputList      = null;
        $rules           = null;
        $kelasList       = null;

        switch ($tab) {
            case 'siswa':
                $querySiswa = User::where('role', 'siswa')
                    ->withCount('diagnosa')
                    ->with('diagnosaTerakhir.output')
                    ->orderBy('kelas')
                    ->orderBy('name');

                if ($request->kelas) {
                    $querySiswa->where('kelas', $request->kelas);
                }

                $siswa     = $querySiswa->paginate(15, ['*'], 'page')->withQueryString();
                $kelasList = User::where('role', 'siswa')
                    ->whereNotNull('kelas')
                    ->distinct()
                    ->orderBy('kelas')
                    ->pluck('kelas');
                break;

            case 'riwayat':
                $riwayatDiagnosa = Diagnosa::with(['user', 'output'])
                    ->latest()
                    ->paginate(15, ['*'], 'page')
                    ->withQueryString();
                break;

            case 'gejala':
                $gejala = Gejala::orderBy('kode')->paginate(15, ['*'], 'page')->withQueryString();
                break;

            case 'output':
                $outputList = OutputStres::orderBy('kode')->get();
                break;

            case 'aturan':
                $rules = Rule::with(['output', 'ruleGejala'])
                    ->orderBy('kode')
                    ->paginate(15, ['*'], 'page')
                    ->withQueryString();
                break;
        }

        return view('admin.laporan.index', compact(
            'tab', 'siswa', 'riwayatDiagnosa', 'gejala', 'outputList', 'rules', 'kelasList'
        ));
    }

    // ── Cetak per tab ──────────────────────────────────────────
    public function cetakSiswa(Request $request)
    {
        $query = User::where('role', 'siswa')
            ->withCount('diagnosa')
            ->with('diagnosaTerakhir.output')
            ->orderBy('kelas')
            ->orderBy('name');

        if ($request->kelas) {
            $query->where('kelas', $request->kelas);
        }

        $siswa       = $query->get();
        $filterKelas = $request->kelas ?: 'Semua Kelas';

        return view('admin.laporan.cetak-siswa', compact('siswa', 'filterKelas'));
    }

    public function cetakRiwayat()
    {
        $riwayat = Diagnosa::with(['user', 'output'])->latest()->get();
        return view('admin.laporan.cetak-riwayat', compact('riwayat'));
    }

    public function cetakGejala()
    {
        $gejala = Gejala::orderBy('kode')->get();
        return view('admin.laporan.cetak-gejala', compact('gejala'));
    }

    public function cetakOutput()
    {
        $outputList = OutputStres::orderBy('kode')->get();
        return view('admin.laporan.cetak-output', compact('outputList'));
    }

    public function cetakAturan()
    {
        $rules = Rule::with(['output', 'ruleGejala'])->orderBy('kode')->get();
        return view('admin.laporan.cetak-aturan', compact('rules'));
    }
}