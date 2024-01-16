<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkademikKelasHeader extends Model
{
    public $table = 'akademik_kelas_header';
    
    public $timestamps = false;
    
    use HasFactory;
}
