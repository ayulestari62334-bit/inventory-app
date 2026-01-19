<?php

namespace Modules\InventoryAsset\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\InventoryAsset\Database\Factories\LokasiFactory;

class Lokasi extends Model
{
    protected $table = 'lokasi';
    
    protected $fillable = [
        'kode_lokasi',
        'nama_lokasi',
        'tipe_lokasi',
        'keterangan'
    ];
}
