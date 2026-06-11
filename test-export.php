<?php

use App\Exports\SupplierExport;
use App\Exports\TemplateExport;
use Maatwebsite\Excel\Facades\Excel;

// Bootstrap Laravel
require __DIR__ . '/bootstrap/app.php';

try {
    echo "Testing SupplierExport...\n";
    $export = new SupplierExport();
    echo "✓ SupplierExport instantiated successfully\n";

    echo "\nTesting TemplateExport...\n";
    $templateExport = new TemplateExport(
        ['kode', 'nama_supplier', 'alamat'],
        [['S001', 'PT Test', 'Jakarta']]
    );
    echo "✓ TemplateExport instantiated successfully\n";

    echo "\nAll tests passed!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
