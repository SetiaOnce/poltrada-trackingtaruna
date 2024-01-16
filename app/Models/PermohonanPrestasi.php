<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanPrestasi extends Model
{
    public $table = 'pusbintar_permohonan_prestasi';
    
    public $timestamps = false;

    use HasFactory;

    public function prestasi()
    {
    	return $this->belongsTo('App\Models\Prestasi', 'jenis_prestasi', 'id'); 
    } 
    public function subPrestasi()
    {
    	return $this->belongsTo('App\Models\SubPrestasi', 'jenis_sub_prestasi', 'id'); 
    } 
    public function tahunajaran()
    {
    	return $this->belongsTo('App\Models\AkademikTahunAjaran', 'tahun_ajaran_id', 'id'); 
    } 
}
