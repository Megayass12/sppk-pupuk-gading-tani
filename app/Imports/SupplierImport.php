<?php

namespace App\Imports;

use App\Models\Kriteria;
use App\Models\PenilaianSupplier;
use App\Models\Supplier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class SupplierImport implements ToCollection, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }

    private function generateSupplierKode(): string
    {
        $lastNumber = Supplier::where('kode', 'like', 'S%')
            ->get()
            ->map(fn($item) => intval(preg_replace('/[^0-9]/', '', $item->kode)))
            ->max();

        $nextNumber = ($lastNumber ?? 0) + 1;

        return 'S' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function collection(Collection $rows)
    {
        $kriteriaHeadings = Kriteria::orderBy('id')
            ->get()
            ->mapWithKeys(fn($item) => ['Kriteria: ' . $item->nama_kriteria => $item->id])
            ->toArray();

        foreach ($rows as $row) {
            $rowArray = $row->toArray();

            if (empty($rowArray['nama_supplier'] ?? null)) {
                continue;
            }

            $kode = isset($rowArray['kode']) && trim($rowArray['kode']) !== ''
                ? trim($rowArray['kode'])
                : $this->generateSupplierKode();

            $supplier = Supplier::updateOrCreate(
                ['kode' => $kode],
                [
                    'nama_supplier' => $row['nama_supplier'] ?? '',
                    'alamat' => $row['alamat'] ?? '',
                    'no_telp' => $row['no_telp'] ?? '',
                    'email' => $row['email'] ?? '',
                ]
            );

            foreach ($kriteriaHeadings as $heading => $kriteriaId) {
                if (!isset($row[$heading]) || $row[$heading] === null || $row[$heading] === '') {
                    continue;
                }

                // Validasi nilai harus numeric dan dalam range 0-5
                $rawValue = $row[$heading];
                if (!is_numeric($rawValue)) {
                    continue;
                }

                $nilai = (float) $rawValue;
                if ($nilai >= 0 && $nilai <= 5) {
                    PenilaianSupplier::updateOrCreate(
                        ['supplier_id' => $supplier->id, 'kriteria_id' => $kriteriaId],
                        ['nilai' => $nilai]
                    );
                }
            }
        }
    }
}
