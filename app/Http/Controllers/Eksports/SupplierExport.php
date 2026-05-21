<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SupplierExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Supplier::all();
    }

    public function headings(): array
    {
        return [
            'kode_supplier', 'nama_supplier', 'alamat', 'telepon',
            'harga', 'kualitas', 'ketepatan_waktu', 'kapasitas', 'jarak',
        ];
    }

    public function map($row): array
    {
        return [
            $row->kode_supplier,
            $row->nama_supplier,
            $row->alamat,
            $row->telepon,
            $row->harga,
            $row->kualitas,
            $row->ketepatan_waktu,
            $row->kapasitas,
            $row->jarak,
        ];
    }
}
