<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganTarif extends Model
{
    public $table = 'keuangan_tarif';
    
    public $timestamps = false;
    
    protected $fillable = [
        'subjenis_id',
        'satuan_id',
        'kode_akun_id',
        'tarif',
    ];
    
    use HasFactory;

    public function satuan()
    {
    	return $this->belongsTo('App\Models\KeuanganSatuan', 'satuan_id', 'id'); 
    } 
    public function kodeAkun()
    {
    	return $this->belongsTo('App\Models\KeuanganKodeAkun', 'kode_akun_id', 'id'); 
    } 
    public function subjenispenerimaan()
    {
    	return $this->belongsTo('App\Models\KeuanganSubJenisPenerimaan', 'subjenis_id', 'id'); 
    } 
}
