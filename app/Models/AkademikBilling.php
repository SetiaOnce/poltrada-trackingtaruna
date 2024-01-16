<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkademikBilling extends Model
{
    public $table = 'akademik_billing';
    
    public $timestamps = false;
    
    use HasFactory;
}