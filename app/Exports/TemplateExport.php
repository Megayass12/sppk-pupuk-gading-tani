<?php

namespace App\Exports;

use App\Models\Kriteria;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths, WithEvents
{
    protected $headers;
    protected $contoh;
    protected $kriteriaList;

    public function __construct(array $headers, array $contoh)
    {
        $this->headers = $headers;
        $this->contoh = $contoh;
        $this->kriteriaList = Kriteria::orderBy('id')->get();
    }

    public function headings(): array
    {
        return $this->headers;
    }

    public function array(): array
    {
        return $this->contoh;
    }

    public function columnWidths(): array
    {
        $widths = [
            'A' => 20,  // nama_supplier
            'B' => 25,  // alamat
            'C' => 15,  // no_telp
            'D' => 20,  // email
        ];

        // Set width untuk kolom kriteria
        $col = 'E';
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

        $baseColumn = 4 + count($this->kriteriaList);
        $sheet->getStyle('A1:' . chr(64 + $baseColumn) . '1')->applyFromArray($headerStyle);

        // Set row height for header
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Center align contoh data
        $lastColumn = chr(64 + $baseColumn);
        $sheet->getStyle('A2:' . $lastColumn . 2)->applyFromArray([
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
                $noteStartRow = 4;
                $noteCol = 4 + count($this->kriteriaList) + 2; // satu spacer setelah kriteria
                $noteLabelCol = chr(64 + $noteCol);
                $noteDescCol = chr(64 + $noteCol + 1);

                // Judul catatan template
                $titleRow = $noteStartRow;
                $sheet->setCellValue($noteLabelCol . $titleRow, 'KETERANGAN TEMPLATE');
                $sheet->getStyle($noteLabelCol . $titleRow)->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '4472C4']],
                ]);

                $currentRow = $titleRow + 1;
                $sheet->setCellValue($noteLabelCol . $currentRow, 'Kode supplier akan diisi otomatis oleh sistem.');
                $sheet->getStyle($noteLabelCol . $currentRow)->applyFromArray([
                    'font' => ['size' => 10, 'color' => ['rgb' => '000000']],
                    'alignment' => ['wrapText' => true],
                ]);
                $sheet->mergeCells($noteLabelCol . $currentRow . ':' . $noteDescCol . $currentRow);
                $currentRow += 2;

                // Tambahkan keterangan untuk setiap kriteria
                foreach ($this->kriteriaList as $index => $item) {
                    $isBenefit = $item->atribut === 'benefit';

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
