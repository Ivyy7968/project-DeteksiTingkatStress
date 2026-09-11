<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
class ForwardChainingEngine
{
    /**
     * @param  array $gejalaDipilih  Array kode gejala: ['G01','G05',...]
     * @return array ['output_kode', 'rule_cocok', 'matched_rules']
     */
    public function run(array $gejalaDipilih): array
    {
        $rules = DB::table('rules')
            ->join('rule_gejala', 'rules.id', '=', 'rule_gejala.rule_id')
            ->select('rules.id', 'rules.kode', 'rules.output_kode',
                     'rule_gejala.gejala_kode', 'rule_gejala.is_negasi')
            ->get()
            ->groupBy('id');
 
        // Urutkan output dari tertinggi ke terendah
        $prioritas = ['S5','S4','S3','S2','S1'];
        $matchedByLevel = [];
 
        foreach ($rules as $ruleId => $conditions) {
            $ruleKode   = $conditions->first()->kode;
            $outputKode = $conditions->first()->output_kode;
            $isNegasi   = (bool) $conditions->first()->is_negasi;
 
            if ($isNegasi) {
                // R26: NONE of the listed gejala should be present
                $anyPresent = false;
                foreach ($conditions as $c) {
                    if (in_array($c->gejala_kode, $gejalaDipilih)) {
                        $anyPresent = true;
                        break;
                    }
                }
                if (!$anyPresent) {
                    $matchedByLevel[$outputKode][] = $ruleKode;
                }
            } else {
                // Normal AND rule: ALL gejala must be present
                $allPresent = true;
                foreach ($conditions as $c) {
                    if (!in_array($c->gejala_kode, $gejalaDipilih)) {
                        $allPresent = false;
                        break;
                    }
                }
                if ($allPresent) {
                    $matchedByLevel[$outputKode][] = $ruleKode;
                }
            }
        }
 
        // Ambil hasil dengan prioritas tertinggi
        foreach ($prioritas as $level) {
            if (!empty($matchedByLevel[$level])) {
                return [
                    'output_kode'   => $level,
                    'rule_cocok'    => $matchedByLevel[$level][0],
                    'matched_rules' => $matchedByLevel[$level],
                ];
            }
        }
 
        // Fallback: jika tidak ada rule cocok, hitung berdasarkan jumlah gejala
        $count = count($gejalaDipilih);
        if ($count === 0) {
            $output = 'S1';
        } elseif ($count <= 3) {
            $output = 'S2';
        } elseif ($count <= 6) {
            $output = 'S3';
        } elseif ($count <= 10) {
            $output = 'S4';
        } else {
            $output = 'S5';
        }
 
        return [
            'output_kode'   => $output,
            'rule_cocok'    => null,
            'matched_rules' => [],
        ];
    }
}
 