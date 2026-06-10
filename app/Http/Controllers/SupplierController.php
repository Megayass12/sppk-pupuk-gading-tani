<?php

namespace App\Http\Controllers;

use App\Exports\SupplierExport;
use App\Exports\TemplateExport;
use App\Imports\SupplierImport;
use App\Models\Kriteria;
use App\Models\PenilaianSupplier;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;

class SupplierController extends Controller
{
    private function buildSupplierKriteriaFields(): array
    {
        $kriteria = Kriteria::orderBy('id')->get();

        return $kriteria->map(function ($item, $index) {
            $isBenefit = $item->atribut === 'benefit';

            // Scale guide berdasarkan jenis kriteria
            if ($isBenefit) {
                $scaleGuide = [
                    ['value' => 1, 'label' => '1 = Sangat Buruk'],
                    ['value' => 2, 'label' => '2 = Buruk'],
                    ['value' => 3, 'label' => '3 = Cukup Baik'],
                    ['value' => 4, 'label' => '4 = Baik'],
                    ['value' => 5, 'label' => '5 = Sangat Baik'],
                ];
            } else {
                $scaleGuide = [
                    ['value' => 1, 'label' => '1 = Sangat Baik (Paling Murah)'],
                    ['value' => 2, 'label' => '2 = Baik'],
                    ['value' => 3, 'label' => '3 = Cukup Baik'],
                    ['value' => 4, 'label' => '4 = Buruk'],
                    ['value' => 5, 'label' => '5 = Sangat Buruk (Paling Mahal)'],
                ];
            }

            return [
                'id' => $item->id,
                'kode' => 'C' . ($index + 1),
                'name' => "nilai[{$item->id}]",
                'label' => sprintf('%s – %s', 'C' . ($index + 1), $item->nama_kriteria),
                'attribute' => $item->atribut,
                'badgeLabel' => $isBenefit ? '↑ Lebih Tinggi Lebih Baik' : '↓ Lebih Rendah Lebih Baik',
                'badgeClass' => $isBenefit ? 'badge-benefit' : 'badge-cost',
                'step' => '1',
                'min' => 1,
                'max' => 5,
                'scaleGuide' => $scaleGuide,
                'required' => true,
                'kriteria' => $item,
            ];
        })->toArray();
    }

    private function supplierRules(?Supplier $supplier = null): array
    {
        $rules = [
            'kode' => 'required|unique:suppliers' . ($supplier ? ',kode,' . $supplier->id : ''),
            'nama_supplier' => 'required',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'email' => 'nullable|email',
        ];

        $kriteria = Kriteria::orderBy('id')->get();
        if ($kriteria->isNotEmpty()) {
            $rules['nilai'] = 'required|array';
            foreach ($kriteria as $item) {
                $rules['nilai.' . $item->id] = 'required|integer|min:1|max:5';
            }
        } else {
            $rules['nilai'] = 'nullable|array';
        }

        return $rules;
    }

    private function supplierBaseData(Request $request): array
    {
        return $request->only(['kode', 'nama_supplier', 'alamat', 'no_telp', 'email']);
    }

    private function syncSupplierPenilaian(Supplier $supplier, array $nilai): void
    {
        $kriteria = Kriteria::orderBy('id')->get();

        foreach ($kriteria as $item) {
            $value = isset($nilai[$item->id]) ? (int) $nilai[$item->id] : 1;

            PenilaianSupplier::updateOrCreate(
                ['supplier_id' => $supplier->id, 'kriteria_id' => $item->id],
                ['nilai' => $value]
            );
        }
    }

    public function index()
    {
        $suppliers = Supplier::with('penilaian')->latest()->paginate(10);
        $kriteria = Kriteria::orderBy('id')->get();

        return view('supplier.index', compact('suppliers', 'kriteria'));
    }

    public function create()
    {
        $kriteriaFields = $this->buildSupplierKriteriaFields();
        return view('supplier.create', compact('kriteriaFields'));
    }

    public function store(Request $request)
    {
        $request->validate($this->supplierRules());

        $supplier = Supplier::create($this->supplierBaseData($request));
        $this->syncSupplierPenilaian($supplier, $request->input('nilai', []));

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        $kriteriaFields = $this->buildSupplierKriteriaFields();
        $nilai = $supplier->penilaian->pluck('nilai', 'kriteria_id')->toArray();

        return view('supplier.edit', compact('supplier', 'kriteriaFields', 'nilai'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate($this->supplierRules($supplier));

        $supplier->update($this->supplierBaseData($request));
        $this->syncSupplierPenilaian($supplier, $request->input('nilai', []));

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus.');
    }

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

    public function export()
    {
        return Excel::download(new SupplierExport, 'data-supplier.xlsx');
    }

    public function template()
    {
        $kriteria = Kriteria::orderBy('id')->get();

        $headers = array_merge(
            ['kode', 'nama_supplier', 'alamat', 'no_telp', 'email'],
            $kriteria->map(fn($item) => 'Kriteria: ' . $item->nama_kriteria)->toArray()
        );

        $example = array_merge(
            ['S001', 'PT Contoh Pupuk', 'Surabaya', '08123456789', 'info@contoh.com'],
            $kriteria->map(fn() => 0)->toArray()
        );

        return Excel::download(new TemplateExport($headers, [$example]), 'template-supplier.xlsx');
    }
}
