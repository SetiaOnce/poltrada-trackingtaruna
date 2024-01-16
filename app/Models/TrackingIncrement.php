<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingIncrement extends Model
{
    public $table = 'trackingtaruna_tracking_views';

    public $timestamps = false;

    protected $guarded = [];
    
    use HasFactory;
}
