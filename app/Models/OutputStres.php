<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class OutputStres extends Model
{
    protected $table    = 'output_stres';
    protected $fillable = ['kode','tingkat','deskripsi','rekomendasi','warna'];
}