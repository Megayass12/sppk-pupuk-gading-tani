<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TemplateExport implements FromArray, WithHeadings
{
    protected $headers;
    protected $contoh;

    public function __construct(array $headers, array $contoh)
    {
        $this->headers = $headers;
        $this->contoh  = $contoh;
    }

    public function headings(): array
    {
        return $this->headers;
    }

    public function array(): array
    {
        return $this->contoh;
    }
}
