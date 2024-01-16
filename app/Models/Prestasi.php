<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    public $table = 'pusbintar_prestasi';
    
    public $timestamps = false;
    
    use HasFactory;
}
