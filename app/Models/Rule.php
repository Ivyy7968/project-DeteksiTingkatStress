<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $table    = 'rules';
    protected $fillable = ['kode','output_kode'];
    public $timestamps  = true;

    public function output()
    {
        return $this->belongsTo(OutputStres::class, 'output_kode', 'kode');
    }

    public function ruleGejala()
    {
        return $this->hasMany(RuleGejala::class);
    }

    // Gejala (kode) yang dipakai rule ini, urut sesuai input
    public function gejalaKode(): array
    {
        return $this->ruleGejala->pluck('gejala_kode')->all();
    }

    public function isNegasi(): bool
    {
        return (bool) ($this->ruleGejala->first()->is_negasi ?? false);
    }
}