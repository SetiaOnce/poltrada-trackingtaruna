<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileApp extends Model
{
    public $table = 'trackingtaruna_site_info';

    protected $guarded = [];
    
    use HasFactory;
}
