<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Imports\SupplierImport;
use App\Exports\SupplierExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TemplateExport;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_supplier'  => 'required|unique:suppliers',
            'nama_supplier'  => 'required',
            'harga'          => 'required|numeric|min:0',
            'kualitas'       => 'required|numeric|min:1|max:10',
            'ketepatan_waktu'=> 'required|integer|min:0|max:100',
            'kapasitas'      => 'required|integer|min:0',
            'jarak'          => 'required|numeric|min:0',
        ]);

        Supplier::create($request->all());
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'kode_supplier'  => 'required|unique:suppliers,kode_supplier,' . $supplier->id,
            'nama_supplier'  => 'required',
            'harga'          => 'required|numeric|min:0',
            'kualitas'       => 'required|numeric|min:1|max:10',
            'ketepatan_waktu'=> 'required|integer|min:0|max:100',
            'kapasitas'      => 'required|integer|min:0',
            'jarak'          => 'required|numeric|min:0',
        ]);

        $supplier->update($request->all());
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
