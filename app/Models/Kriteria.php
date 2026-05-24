<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kriteria extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_kriteria',
        'atribut',
        'bobot',
    ];

    public function penilaian()
    {
        return $this->hasMany(PenilaianSupplier::class);
    }
}
