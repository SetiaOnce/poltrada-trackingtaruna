<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganKodeAkun extends Model
{
    public $table = 'keuangan_kode_akun';
    
    public $timestamps = false;
    
    protected $fillable = [
        'kode_akun',
    ];
    
    use HasFactory;
}
