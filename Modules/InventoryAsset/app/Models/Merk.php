<?php

namespace Modules\InventoryAsset\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merk extends Model
{
    use HasFactory;

    protected $table = 'merk_barang';

    protected $fillable = [
        'kode_merk',
        'nama_merk',
        'keterangan',
    ];
}