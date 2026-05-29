<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\PenilaianSupplier;
use App\Models\Supplier;

class RekomendasiController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::with('penilaian')->get();
        $kriteria = Kriteria::orderBy('id')->get();
        $totalBobot = $kriteria->sum('bobot');

        if ($suppliers->isEmpty() || $kriteria->isEmpty() || abs($totalBobot - 1.0) > 0.0001) {
            $error = 'Data supplier atau kriteria tidak lengkap. Pastikan ada supplier dan total kriteria harus = 1.';
            if ($suppliers->isEmpty() || $kriteria->isEmpty()) {
                $error = 'Data supplier atau kriteria masih kosong.';
            } elseif (abs($totalBobot - 1.0) > 0.0001) {
                $error = 'Total kriteria harus = 1 sebelum proses rekomendasi dapat dijalankan.';
            }

            return view('rekomendasi.index', [
                'hasil' => [],
                'matriks' => [],
                'normal' => [],
                'kriteria' => $kriteria,
                'suppliers' => $suppliers,
                'error' => $error,
            ]);
        }

        $nilaiSupplier = PenilaianSupplier::whereIn('supplier_id', $suppliers->pluck('id'))
            ->get()
            ->groupBy('supplier_id');

        $matriks = [];
        foreach ($suppliers as $supplier) {
            $baris = [];
            foreach ($kriteria as $index => $krit) {
                $nilai = $nilaiSupplier[$supplier->id]->firstWhere('kriteria_id', $krit->id)->nilai ?? 0;
                $baris['C' . ($index + 1)] = (float) $nilai;
            }
            $matriks[$supplier->id] = $baris;
        }

        $normal = [];
        foreach ($kriteria as $index => $krit) {
            $kode = 'C' . ($index + 1);
            $nilaiKolom = array_column($matriks, $kode);
            $acuan = $krit->atribut === 'benefit' ? max($nilaiKolom) : min($nilaiKolom);

            foreach ($suppliers as $supplier) {
                $nilai = $matriks[$supplier->id][$kode];
                if ($krit->atribut === 'benefit') {
                    $normal[$supplier->id][$kode] = $acuan == 0 ? 0 : $nilai / $acuan;
                } else {
                    $normal[$supplier->id][$kode] = $nilai == 0 ? 1 : $acuan / $nilai;
                }
            }
        }

        $hasil = [];
        foreach ($suppliers as $supplier) {
            $vi = 0;
            foreach ($kriteria as $index => $krit) {
                $kode = 'C' . ($index + 1);
                $vi += (float) $krit->bobot * ($normal[$supplier->id][$kode] ?? 0);
            }
            $hasil[] = [
                'supplier' => $supplier,
                'vi' => round($vi, 2),
                'normal' => $normal[$supplier->id],
                'matriks' => $matriks[$supplier->id],
            ];
        }

        usort($hasil, fn($a, $b) => $b['vi'] <=> $a['vi']);

        foreach ($hasil as $i => &$item) {
            $item['ranking'] = $i + 1;
        }

        return view('rekomendasi.index', compact('hasil', 'matriks', 'normal', 'kriteria', 'suppliers'));
    }
}
