<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanPelanggaran extends Model
{
    public $table = 'pusbintar_permohonan_pelanggaran';
    
    public $timestamps = false;

    use HasFactory;

    public function pelanggaran()
    {
    	return $this->belongsTo('App\Models\Pelanggaran', 'jenis_pelanggaran', 'id'); 
    } 
    public function subpelanggaran()
    {
    	return $this->belongsTo('App\Models\SubPelanggaran', 'jenis_sub_pelanggaran', 'id'); 
    } 
    public function tahunajaran()
    {
    	return $this->belongsTo('App\Models\AkademikTahunAjaran', 'tahun_ajaran_id', 'id'); 
    } 
}
