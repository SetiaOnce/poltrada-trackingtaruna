<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkademikBillingDetail extends Model
{
    public $table = 'akademik_billing_detail';
    
    public $timestamps = false;
    
    use HasFactory;
}