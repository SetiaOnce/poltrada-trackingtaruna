<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganJenisPenerimaan extends Model
{
    public $table = 'keuangan_jenis_penerimaan';
    
    public $timestamps = false;
    
    protected $fillable = [
        'jenispenerimaan',
    ];
    
    use HasFactory;
}
