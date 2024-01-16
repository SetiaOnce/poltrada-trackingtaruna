<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkademikRiwayatPendidikan extends Model
{
    public $table = 'akademik_riwayat_pendidikan';

    public $timestamps = false;
    
    use HasFactory;
}
