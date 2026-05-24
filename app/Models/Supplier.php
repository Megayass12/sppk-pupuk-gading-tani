<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama_supplier',
        'alamat',
        'no_telp',
        'email',
    ];

    public function penilaian()
    {
        return $this->hasMany(PenilaianSupplier::class);
    }
}
