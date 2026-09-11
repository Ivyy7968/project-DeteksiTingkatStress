<?php

namespace App\Http\Controllers;

use App\Models\Diagnosa;
use App\Models\Gejala;
use App\Models\OutputStres;
use App\Services\ForwardChainingEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $user             = Auth::user();
        $diagnosaTerakhir = Diagnosa::with('output')
            ->where('user_id', $user->id)
            ->latest()
            ->first();
        $riwayat = Diagnosa::with('output')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact('user','diagnosaTerakhir','riwayat'));
    }

    // ── Diagnosa ─────────────────────────────────────────────────
    public function startDiagnosa()
    {
        $gejala = Gejala::orderBy('kode')->get();
        return view('diagnosis.start', compact('gejala'));
    }

    public function submitDiagnosa(Request $request, ForwardChainingEngine $engine)
    {
        $gejalaDipilih = $request->input('gejala', []);

        $result = $engine->run($gejalaDipilih);

        $diagnosa = Diagnosa::create([
            'user_id'        => Auth::id(),
            'output_kode'    => $result['output_kode'],
            'gejala_dipilih' => $gejalaDipilih,
            'rule_cocok'     => $result['rule_cocok'],
        ]);

        return redirect()->route('siswa.hasil', $diagnosa->id);
    }

    public function hasil($id)
    {
        $diagnosa = Diagnosa::with(['output','user'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $gejalaDipilih = Gejala::whereIn('kode', $diagnosa->gejala_dipilih)->get();

        return view('diagnosis.hasil', compact('diagnosa','gejalaDipilih'));
    }

    // ── Cetak Hasil Diagnosa ─────────────────────────────────────
    public function cetakHasil($id)
    {
        $diagnosa = Diagnosa::with(['output','user'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $gejalaDipilih = Gejala::whereIn('kode', $diagnosa->gejala_dipilih)->get();

        return view('student.cetak-hasil', compact('diagnosa','gejalaDipilih'));
    }

    // ── Riwayat ──────────────────────────────────────────────────
    public function riwayat()
    {
        $riwayat = Diagnosa::with('output')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('student.riwayat', compact('riwayat'));
    }
}