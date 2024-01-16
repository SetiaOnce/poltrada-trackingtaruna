<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganSumberPendapatan extends Model
{
    public $table = 'keuangan_sumber_pendapatan';
    
    public $timestamps = false;
    
    protected $fillable = [
        'sumber',
    ];
    
    use HasFactory;
}
