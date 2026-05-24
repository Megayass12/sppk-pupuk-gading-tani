<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Bobot;

class RekomendasiController extends Controller
{
    // Mapping kolom database ke kode kriteria
    private $kolomKriteria = [
        'C1' => 'harga',
        'C2' => 'kualitas',
        'C3' => 'ketepatan_waktu',
        'C4' => 'kapasitas',
        'C5' => 'jarak',
    ];

    public function index()
    {
        $suppliers = Supplier::all();
        $bobots    = Bobot::all();
        $totalBobot = $bobots->sum('bobot');

        if ($suppliers->isEmpty() || $bobots->isEmpty() || abs($totalBobot - 1.0) > 0.0001) {
            $error = 'Data supplier atau bobot tidak lengkap. Pastikan ada supplier dan total bobot harus = 1.';
            if ($suppliers->isEmpty() || $bobots->isEmpty()) {
                $error = 'Data supplier atau bobot masih kosong.';
            } elseif (abs($totalBobot - 1.0) > 0.0001) {
                $error = 'Total bobot harus = 1 sebelum proses rekomendasi dapat dijalankan.';
            }

            return view('rekomendasi.index', [
                'hasil'     => [],
                'matriks'   => [],
                'normal'    => [],
                'bobots'    => $bobots,
                'suppliers' => $suppliers,
                'error'     => $error,
            ]);
        }

        // --- STEP 1: Bangun matriks keputusan ---
        $matriks = [];
        foreach ($suppliers as $s) {
            $baris = [];
            foreach ($bobots as $b) {
                $kolom = $this->kolomKriteria[$b->kode] ?? null;
                $baris[$b->kode] = $kolom ? (float)$s->$kolom : 0;
            }
            $matriks[$s->id] = $baris;
        }

        // --- STEP 2: Normalisasi matriks R ---
        $normal = [];
        foreach ($bobots as $b) {
            $nilaiKolom = array_column($matriks, $b->kode);

            if ($b->tipe === 'benefit') {
                $acuan = max($nilaiKolom); // max untuk benefit
            } else {
                $acuan = min($nilaiKolom); // min untuk cost
            }

            foreach ($suppliers as $s) {
                $nilai = $matriks[$s->id][$b->kode];
                if ($acuan == 0) {
                    $normal[$s->id][$b->kode] = 0;
                } elseif ($b->tipe === 'benefit') {
                    $normal[$s->id][$b->kode] = $nilai / $acuan;
                } else {
                    $normal[$s->id][$b->kode] = $acuan / $nilai;
                }
            }
        }

        // --- STEP 3: Hitung nilai preferensi (Vi = Σ wj * rij) ---
        $hasil = [];
        foreach ($suppliers as $s) {
            $vi = 0;
            foreach ($bobots as $b) {
                $vi += (float)$b->bobot * $normal[$s->id][$b->kode];
            }
            $hasil[] = [
                'supplier'  => $s,
                'vi'        => round($vi, 4),
                'normal'    => $normal[$s->id],
                'matriks'   => $matriks[$s->id],
            ];
        }

        // --- STEP 4: Urutkan dari nilai Vi tertinggi ---
        usort($hasil, fn($a, $b) => $b['vi'] <=> $a['vi']);

        // Tambahkan ranking
        foreach ($hasil as $i => &$h) {
            $h['ranking'] = $i + 1;
        }

        return view('rekomendasi.index', compact('hasil', 'matriks', 'normal', 'bobots', 'suppliers'));
    }
}
