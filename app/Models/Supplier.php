<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_supplier',
        'nama_supplier',
        'alamat',
        'telepon',
        'harga',
        'kualitas',
        'ketepatan_waktu',
        'kapasitas',
        'jarak',
    ];
}
