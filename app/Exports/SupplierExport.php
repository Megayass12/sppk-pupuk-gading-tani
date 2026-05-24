<?php

namespace App\Exports;

use App\Models\Kriteria;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SupplierExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Supplier::with('penilaian')->get();
    }

    public function headings(): array
    {
        $kriteria = Kriteria::orderBy('id')->get();

        return array_merge(
            ['kode', 'nama_supplier', 'alamat', 'no_telp', 'email'],
            $kriteria->map(fn($item) => 'Kriteria: ' . $item->nama_kriteria)->toArray()
        );
    }

    public function map($row): array
    {
        $nilaiMap = $row->penilaian->pluck('nilai', 'kriteria_id')->toArray();
        $kriteria = Kriteria::orderBy('id')->get();

        return array_merge(
            [
                $row->kode,
                $row->nama_supplier,
                $row->alamat,
                $row->no_telp,
                $row->email,
            ],
            $kriteria->map(fn($item) => $nilaiMap[$item->id] ?? 0)->toArray()
        );
    }
}
