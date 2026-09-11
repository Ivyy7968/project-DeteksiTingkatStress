<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleGejala extends Model
{
    protected $table    = 'rule_gejala';
    protected $fillable = ['rule_id','gejala_kode','is_negasi'];
    public $timestamps  = false;

    protected $casts = ['is_negasi' => 'boolean'];

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }
}