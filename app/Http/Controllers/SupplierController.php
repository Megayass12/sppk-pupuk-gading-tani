<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Kriteria;
use App\Imports\SupplierImport;
use App\Exports\SupplierExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TemplateExport;

class SupplierController extends Controller
{
    private function supplierKodeKolom(): array
    {
        return [
            'C1' => 'harga',
            'C2' => 'kualitas',
            'C3' => 'ketepatan_waktu',
            'C4' => 'kapasitas',
            'C5' => 'jarak',
        ];
    }

    private function buildSupplierKriteriaFields(): array
    {
        $defaults = [
            'C1' => [
                'kode' => 'C1',
                'column' => 'harga',
                'label' => 'C1 – Harga (Rp/kg)',
                'badge' => 'COST',
                'step' => '0.01',
                'min' => 0,
                'max' => null,
                'required' => true,
            ],
            'C2' => [
                'kode' => 'C2',
                'column' => 'kualitas',
                'label' => 'C2 – Kualitas (1–10)',
                'badge' => 'BENEFIT',
                'step' => '0.1',
                'min' => 1,
                'max' => 10,
                'required' => true,
            ],
            'C3' => [
                'kode' => 'C3',
                'column' => 'ketepatan_waktu',
                'label' => 'C3 – Ketepatan Waktu (%)',
                'badge' => 'BENEFIT',
                'step' => '1',
                'min' => 0,
                'max' => 100,
                'required' => true,
            ],
            'C4' => [
                'kode' => 'C4',
                'column' => 'kapasitas',
                'label' => 'C4 – Kapasitas (ton/bulan)',
                'badge' => 'BENEFIT',
                'step' => '1',
                'min' => 0,
                'max' => null,
                'required' => true,
            ],
            'C5' => [
                'kode' => 'C5',
                'column' => 'jarak',
                'label' => 'C5 – Jarak (km)',
                'badge' => 'COST',
                'step' => '0.01',
                'min' => 0,
                'max' => null,
                'required' => true,
            ],
        ];

        $kriteria = Kriteria::orderBy('kode')->get();
        if ($kriteria  ->isEmpty()) {
            return array_values($defaults);
        }

        $fields = [];
        foreach ($kriteria as $krit ) {
            if (!isset($defaults[$krit->kode])) {
                continue;
            }

            $item = $defaults[$krit->kode];
            $item['label'] = $krit->kode . ' – ' . $krit->kriteria;
            $item['badge'] = strtoupper($krit->tipe);
            $fields[] = $item;
        }

        return empty($fields) ? array_values($defaults) : $fields;
    }

    private function supplierKriteriaRules(): array
    {
        $rules = [
            'kode_supplier' => 'required|unique:suppliers',
            'nama_supplier' => 'required',
            'alamat'        => 'nullable|string',
            'telepon'       => 'nullable|string',
        ];

        foreach ($this->buildSupplierKriteriaFields() as $field) {
            switch ($field['column']) {
                case 'kualitas':
                    $rules[$field['column']] = 'required|numeric|min:1|max:10';
                    break;
                case 'ketepatan_waktu':
                    $rules[$field['column']] = 'required|integer|min:0|max:100';
                    break;
                case 'kapasitas':
                    $rules[$field['column']] = 'required|integer|min:0';
                    break;
                default:
                    $rules[$field['column']] = 'required|numeric|min:0';
                    break;
            }
        }

        return $rules;
    }

    private function supplierKriteriaData(Request $request): array
    {
        $data = $request->only(['kode_supplier', 'nama_supplier', 'alamat', 'telepon']);

        foreach ($this->buildSupplierKriteriaFields() as $field) {
            $data[$field['column']] = $request->input($field['column'], 0);
        }

        return $data;
    }

    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        $kriteriaFields = $this->buildSupplierKriteriaFields();
        $unsupportedBobyts = Kriteria::whereNotIn('kode', array_keys($this->supplierKodeKolom()))->get();
        return view('supplier.create', compact('kriteriaFields', 'unsupportedBobyts'));
    }

    public function store(Request $request)
    {
        $request->validate($this->supplierKriteriaRules());

        Supplier::create($this->supplierKriteriaData($request));
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        $kriteriaFields = $this->buildSupplierKriteriaFields();
        $unsupportedBobyts = Kriteria::whereNotIn('kode', array_keys($this->supplierKodeKolom()))->get();
        return view('supplier.edit', compact('supplier', 'kriteriaFields', 'unsupportedBobyts'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $rules = $this->supplierKriteriaRules();
        $rules['kode_supplier'] = 'required|unique:suppliers,kode_supplier,' . $supplier->id;

        $request->validate($rules);

        $supplier->update($this->supplierKriteriaData($request));
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus.');
    }

    // Import dari Excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new SupplierImport, $request->file('file'));
            return redirect()->route('supplier.index')->with('success', 'Data supplier berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    // Export ke Excel
    public function export()
    {
        return Excel::download(new SupplierExport, 'data-supplier.xlsx');
    }

    // Download template Excel
    public function template()
    {
        $headers = ['kode_supplier', 'nama_supplier', 'alamat', 'telepon', 'harga', 'kualitas', 'ketepatan_waktu', 'kapasitas', 'jarak'];
        $contoh  = [['SUP001', 'CV. Contoh', 'Jember', '08123456789', 8000, 8.5, 90, 50, 20]];

        return Excel::download(new TemplateExport($headers, $contoh), 'template-supplier.xlsx');
    }
}
