<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPelanggaran extends Model
{
    public $table = 'pusbintar_sub_pelanggaran';
    
    public $timestamps = false;

    use HasFactory;
}
