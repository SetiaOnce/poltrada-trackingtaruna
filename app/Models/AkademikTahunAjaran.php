<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkademikTahunAjaran extends Model
{
    public $table = 'akademik_tahun_ajaran';
    
    public $timestamps = false;
    
    use HasFactory;
}