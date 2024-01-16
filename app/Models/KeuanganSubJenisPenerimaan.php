<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganSubJenisPenerimaan extends Model
{
    public $table = 'keuangan_sub_jenis_penerimaan';
    
    public $timestamps = false;
    
    protected $fillable = [
        'sumber_id',
        'jenis_id',
        'subjenispenerimaan',
    ];
    
    use HasFactory;

    public function sumber()
    {
    	return $this->belongsTo('App\Models\KeuanganSumberPendapatan', 'sumber_id', 'id'); 
    } 
    public function jenis()
    {
    	return $this->belongsTo('App\Models\KeuanganJenisPenerimaan', 'jenis_id', 'id'); 
    } 
}
