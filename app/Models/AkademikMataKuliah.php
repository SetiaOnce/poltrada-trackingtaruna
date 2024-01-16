<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkademikMataKuliah extends Model
{
    public $table = 'akademik_mata_kuliah';
    
    public $timestamps = false;
    
    use HasFactory;
}
