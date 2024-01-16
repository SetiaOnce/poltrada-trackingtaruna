<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkademikKelas extends Model
{
    public $table = 'akademik_kelas';
    
    public $timestamps = false;
    
    use HasFactory;
}
