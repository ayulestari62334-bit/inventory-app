<?php

namespace Modules\InventoryAsset\app\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    protected $table = 'jenis_barang';

    protected $fillable = [
        'kode_jenis',
        'nama_jenis',
        'keterangan'
    ];
}
