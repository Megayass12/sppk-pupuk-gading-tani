<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class SupplierImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    public function model(array $row)
    {
        if (empty($row['kode_supplier'])) return null;

        return Supplier::updateOrCreate(
            ['kode_supplier' => $row['kode_supplier']],
            [
                'nama_supplier'   => $row['nama_supplier']   ?? '',
                'alamat'          => $row['alamat']          ?? '',
                'telepon'         => $row['telepon']         ?? '',
                'harga'           => $row['harga']           ?? 0,
                'kualitas'        => $row['kualitas']        ?? 0,
                'ketepatan_waktu' => $row['ketepatan_waktu'] ?? 0,
                'kapasitas'       => $row['kapasitas']       ?? 0,
                'jarak'           => $row['jarak']           ?? 0,
            ]
        );
    }
}
