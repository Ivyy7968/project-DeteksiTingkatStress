<?php
// app/Http/Controllers/GejalaController.php
namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\RuleGejala;
use Illuminate\Http\Request;

class GejalaController extends Controller
{
    public function index(Request $request)
    {
        $query = Gejala::query();

        if ($request->search) {
            $q = $request->search;
            $query->where(function ($b) use ($q) {
                $b->where('kode', 'like', "%$q%")
                  ->orWhere('nama', 'like', "%$q%");
            });
        }

        $gejala = $query->orderBy('kode')->paginate(15)->withQueryString();

        // Hitung berapa rule yang memakai setiap gejala (untuk badge info)
        $pemakaian = RuleGejala::selectRaw('gejala_kode, count(distinct rule_id) as total')
            ->groupBy('gejala_kode')
            ->pluck('total', 'gejala_kode');

        return view('admin.gejala.index', compact('gejala', 'pemakaian'));
    }

    public function create()
    {
        $kodeBerikutnya = $this->generateKodeBerikutnya();
        return view('admin.gejala.create', compact('kodeBerikutnya'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:gejala,kode|regex:/^G\d+$/i',
            'nama' => 'required|string|max:255',
        ], [
            'kode.regex' => 'Format kode harus seperti G29, G30, dst.',
        ]);

        Gejala::create([
            'kode' => strtoupper($request->kode),
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.gejala.index')
            ->with('success', 'Gejala baru berhasil ditambahkan. Gejala ini belum aktif di rule manapun — tambahkan ke Data Aturan agar berpengaruh pada hasil diagnosa.');
    }

    public function edit($id)
    {
        $gejala = Gejala::findOrFail($id);
        return view('admin.gejala.edit', compact('gejala'));
    }

    public function update(Request $request, $id)
    {
        $gejala = Gejala::findOrFail($id);

        $request->validate([
            'kode' => "required|string|max:10|unique:gejala,kode,$id|regex:/^G\d+$/i",
            'nama' => 'required|string|max:255',
        ], [
            'kode.regex' => 'Format kode harus seperti G29, G30, dst.',
        ]);

        $kodeLama = $gejala->kode;
        $kodeBaru = strtoupper($request->kode);

        $gejala->update([
            'kode' => $kodeBaru,
            'nama' => $request->nama,
        ]);

        // Jika kode berubah, perbarui juga referensi di rule_gejala
        if ($kodeLama !== $kodeBaru) {
            RuleGejala::where('gejala_kode', $kodeLama)->update(['gejala_kode' => $kodeBaru]);
        }

        return redirect()->route('admin.gejala.index')->with('success', 'Data gejala berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $gejala = Gejala::findOrFail($id);

        $dipakai = RuleGejala::where('gejala_kode', $gejala->kode)->exists();

        if ($dipakai) {
            $jumlahRule = RuleGejala::where('gejala_kode', $gejala->kode)
                ->distinct('rule_id')
                ->count('rule_id');

            return redirect()->route('admin.gejala.index')
                ->with('error', "Gejala {$gejala->kode} tidak dapat dihapus karena masih digunakan di {$jumlahRule} rule. Hapus atau ubah rule tersebut terlebih dahulu di menu Data Aturan.");
        }

        $gejala->delete();

        return redirect()->route('admin.gejala.index')->with('success', 'Gejala berhasil dihapus.');
    }

    private function generateKodeBerikutnya(): string
    {
        $last = Gejala::orderByRaw('CAST(SUBSTRING(kode, 2) AS UNSIGNED) DESC')->first();
        if (!$last) return 'G01';
        $num = (int) substr($last->kode, 1) + 1;
        return 'G' . str_pad($num, 2, '0', STR_PAD_LEFT);
    }
}