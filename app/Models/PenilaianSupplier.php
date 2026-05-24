<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenilaianSupplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_id',
        'kriteria_id',
        'nilai',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
