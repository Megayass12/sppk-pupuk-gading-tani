<?php

namespace App\Exports;

use App\Models\Kriteria;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class SupplierExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithEvents
{
    protected $kriteriaList;
    protected $maxRow = 0;

    public function __construct()
    {
        $this->kriteriaList = Kriteria::orderBy('id')->get();
    }

    public function collection()
    {
        return Supplier::with('penilaian')->get();
    }

    public function headings(): array
    {
        return array_merge(
            ['kode', 'nama_supplier', 'alamat', 'no_telp', 'email'],
            $this->kriteriaList->map(fn($item) => 'Kriteria: ' . $item->nama_kriteria)->toArray()
        );
    }

    public function map($row): array
    {
        $this->maxRow++;
        $nilaiMap = $row->penilaian->pluck('nilai', 'kriteria_id')->toArray();

        return array_merge(
            [
                $row->kode,
                $row->nama_supplier,
                $row->alamat,
                $row->no_telp,
                $row->email,
            ],
            $this->kriteriaList->map(fn($item) => $nilaiMap[$item->id] ?? 0)->toArray()
        );
    }

    public function columnWidths(): array
    {
        $widths = [
            'A' => 12,  // kode
            'B' => 20,  // nama_supplier
            'C' => 25,  // alamat
            'D' => 15,  // no_telp
            'E' => 20,  // email
        ];

        // Set width untuk kolom kriteria
        $col = 'F';
        foreach ($this->kriteriaList as $item) {
            $widths[$col] = 18;
            $col++;
        }

        // Set width untuk area keterangan
        $widths[$col] = 3;  // spacer
        $widths[++$col] = 25;  // label
        $widths[++$col] = 40;  // description

        return $widths;
    }

    public function styles($sheet)
    {
        // Style header row
        $headerStyle = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $baseColumn = 5 + count($this->kriteriaList);
        $sheet->getStyle('A1:' . chr(64 + $baseColumn) . '1')->applyFromArray($headerStyle);

        // Set row height for header
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Center align data
        $lastColumn = chr(64 + $baseColumn);
        $sheet->getStyle('A2:' . $lastColumn . ($this->maxRow + 1))->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D3D3D3'],
                ],
            ],
        ]);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Hitung posisi kolom catatan
                $noteStartRow = $this->maxRow + 3;
                $noteCol = 4 + count($this->kriteriaList) + 2;  // satu spacer setelah kriteria
                $noteLabelCol = chr(64 + $noteCol);
                $noteDescCol = chr(64 + $noteCol + 1);

                // Judul catatan skala
                $titleRow = $noteStartRow;
                $sheet->setCellValue($noteLabelCol . $titleRow, 'KETERANGAN SKALA');
                $sheet->getStyle($noteLabelCol . $titleRow)->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '4472C4']],
                ]);

                $currentRow = $titleRow + 1;

                // Tambahkan keterangan untuk setiap kriteria
                foreach ($this->kriteriaList as $index => $item) {
                    $isBenefit = $item->atribut === 'benefit';
                    $sheetCol = chr(70 + $index);  // Mulai dari kolom F

                    // Nama kriteria
                    $sheet->setCellValue($noteLabelCol . $currentRow, 'C' . ($index + 1) . ': ' . $item->nama_kriteria);
                    $sheet->getStyle($noteLabelCol . $currentRow)->applyFromArray([
                        'font' => ['bold' => true, 'size' => 10],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => $isBenefit ? 'E2EFDA' : 'FCE4D6'],
                        ],
                    ]);

                    $currentRow++;

                    // Tipe atribut
                    $badgeLabel = $isBenefit ? '↑ Lebih Tinggi Lebih Baik' : '↓ Lebih Rendah Lebih Baik';
                    $sheet->setCellValue($noteLabelCol . $currentRow, $badgeLabel);
                    $sheet->getStyle($noteLabelCol . $currentRow)->applyFromArray([
                        'font' => ['italic' => true, 'size' => 9, 'color' => ['rgb' => '595959']],
                    ]);

                    $currentRow++;

                    // Scale guide
                    if ($isBenefit) {
                        $scales = [
                            '5 = Sangat Baik',
                            '4 = Baik',
                            '3 = Cukup Baik',
                            '2 = Buruk',
                            '1 = Sangat Buruk',
                        ];
                    } else {
                        $scales = [
                            '1 = Sangat Baik (Paling Murah)',
                            '2 = Baik',
                            '3 = Cukup Baik',
                            '4 = Buruk',
                            '5 = Sangat Buruk (Paling Mahal)',
                        ];
                    }

                    foreach ($scales as $scale) {
                        $sheet->setCellValue($noteDescCol . $currentRow, $scale);
                        $sheet->getStyle($noteDescCol . $currentRow)->applyFromArray([
                            'font' => ['size' => 9],
                            'alignment' => ['wrapText' => true],
                        ]);
                        $currentRow++;
                    }

                    $currentRow++;  // Add spacing between criteria
                }

                // Set height untuk notes section
                for ($row = $titleRow; $row < $currentRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(18);
                }
            },
        ];
    }
}
