<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bobot extends Model
{
    protected $fillable = [
        'kriteria',
        'kode',
        'tipe',
        'bobot',
        'keterangan',
    ];
}
