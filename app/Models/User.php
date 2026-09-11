<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name','nis','kelas','jenis_kelamin','email','password','role'];
    protected $hidden   = ['password','remember_token'];

    protected $casts = ['password' => 'hashed'];

    public function isAdmin(): bool  { return $this->role === 'admin'; }
    public function isSiswa(): bool  { return $this->role === 'siswa'; }

    public function diagnosa()
    {
        return $this->hasMany(Diagnosa::class);
    }

    public function diagnosaTerakhir()
    {
        return $this->hasOne(Diagnosa::class)->latest();
    }
}