<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Diagnosa extends Model
{
    protected $table    = 'diagnosa';
    protected $fillable = ['user_id','output_kode','gejala_dipilih','rule_cocok'];
    protected $casts    = ['gejala_dipilih' => 'array'];
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    public function output()
    {
        return $this->belongsTo(OutputStres::class, 'output_kode', 'kode');
    }
}