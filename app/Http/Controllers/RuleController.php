<?php
// app/Http/Controllers/RuleController.php
namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\OutputStres;
use App\Models\Rule;
use App\Models\RuleGejala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RuleController extends Controller
{
    public function index(Request $request)
    {
        $query = Rule::with(['output', 'ruleGejala']);

        if ($request->output) {
            $query->where('output_kode', $request->output);
        }

        $rules      = $query->orderBy('kode')->paginate(15)->withQueryString();
        $outputList = OutputStres::orderBy('kode')->get();

        return view('admin.rules.index', compact('rules', 'outputList'));
    }

    public function create()
    {
        $gejalaList     = Gejala::orderBy('kode')->get();
        $outputList     = OutputStres::orderBy('kode')->get();
        $kodeBerikutnya = $this->generateKodeBerikutnya();

        return view('admin.rules.create', compact('gejalaList', 'outputList', 'kodeBerikutnya'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'        => 'required|string|max:10|unique:rules,kode|regex:/^R\d+$/i',
            'output_kode' => 'required|exists:output_stres,kode',
            'gejala'      => 'required|array|min:1',
            'gejala.*'    => 'exists:gejala,kode',
            'is_negasi'   => 'nullable|boolean',
        ], [
            'kode.regex'     => 'Format kode harus seperti R31, R32, dst.',
            'gejala.required'=> 'Pilih minimal satu gejala untuk rule ini.',
        ]);

        DB::transaction(function () use ($request) {
            $rule = Rule::create([
                'kode'        => strtoupper($request->kode),
                'output_kode' => $request->output_kode,
            ]);

            $isNegasi = $request->boolean('is_negasi');
            foreach ($request->gejala as $kodeGejala) {
                RuleGejala::create([
                    'rule_id'     => $rule->id,
                    'gejala_kode' => $kodeGejala,
                    'is_negasi'   => $isNegasi,
                ]);
            }
        });

        return redirect()->route('admin.rules.index')->with('success', 'Rule baru berhasil ditambahkan dan langsung aktif pada sistem forward chaining.');
    }

    public function edit($id)
    {
        $rule       = Rule::with('ruleGejala')->findOrFail($id);
        $gejalaList = Gejala::orderBy('kode')->get();
        $outputList = OutputStres::orderBy('kode')->get();
        $gejalaTerpilih = $rule->ruleGejala->pluck('gejala_kode')->all();
        $isNegasi   = $rule->isNegasi();

        return view('admin.rules.edit', compact('rule', 'gejalaList', 'outputList', 'gejalaTerpilih', 'isNegasi'));
    }

    public function update(Request $request, $id)
    {
        $rule = Rule::findOrFail($id);

        $request->validate([
            'kode'        => "required|string|max:10|unique:rules,kode,$id|regex:/^R\d+$/i",
            'output_kode' => 'required|exists:output_stres,kode',
            'gejala'      => 'required|array|min:1',
            'gejala.*'    => 'exists:gejala,kode',
            'is_negasi'   => 'nullable|boolean',
        ], [
            'kode.regex'      => 'Format kode harus seperti R31, R32, dst.',
            'gejala.required' => 'Pilih minimal satu gejala untuk rule ini.',
        ]);

        DB::transaction(function () use ($request, $rule) {
            $rule->update([
                'kode'        => strtoupper($request->kode),
                'output_kode' => $request->output_kode,
            ]);

            // Ganti seluruh kondisi gejala rule ini
            RuleGejala::where('rule_id', $rule->id)->delete();

            $isNegasi = $request->boolean('is_negasi');
            foreach ($request->gejala as $kodeGejala) {
                RuleGejala::create([
                    'rule_id'     => $rule->id,
                    'gejala_kode' => $kodeGejala,
                    'is_negasi'   => $isNegasi,
                ]);
            }
        });

        return redirect()->route('admin.rules.index')->with('success', 'Rule berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rule = Rule::findOrFail($id);
        $rule->delete(); // rule_gejala ikut terhapus via onDelete('cascade')

        return redirect()->route('admin.rules.index')->with('success', 'Rule berhasil dihapus.');
    }

    private function generateKodeBerikutnya(): string
    {
        $last = Rule::orderByRaw('CAST(SUBSTRING(kode, 2) AS UNSIGNED) DESC')->first();
        if (!$last) return 'R01';
        $num = (int) substr($last->kode, 1) + 1;
        return 'R' . str_pad($num, 2, '0', STR_PAD_LEFT);
    }
}