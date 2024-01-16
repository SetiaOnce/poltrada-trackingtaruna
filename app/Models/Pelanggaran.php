<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    public $table = 'pusbintar_pelanggaran';
    
    public $timestamps = false;
    
    use HasFactory;
}