<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganSatuan extends Model
{
    public $table = 'keuangan_satuan';
    
    public $timestamps = false;
    
    protected $fillable = [
        'nama_satuan',
    ];
    
    use HasFactory;
}
