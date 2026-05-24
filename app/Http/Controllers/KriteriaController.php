<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    private function currentKriteriaTotal(?int $exceptId = null): float
    {
        return Kriteria::when($exceptId, function ($query, $exceptId) {
            return $query->where('id', '!=', $exceptId);
        })->sum('bobot');
    }

    public function index()
    {
        $kriteria = Kriteria::all();
        $totalKriteria = $kriteria->sum('bobot');
        return view('bobot.index', compact('kriteria', 'totalKriteria'));
    }

    public function create()
    {
        return view('bobot.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'      => 'required|unique:kriteria',
            'kriteria'  => 'required',
            'tipe'      => 'required|in:benefit,cost',
            'bobot'     => 'required|numeric|min:0|max:1',
            'keterangan'=> 'nullable',
        ]);

        $newTotal = $this->currentKriteriaTotal() + (float) $request->input('bobot');
        if ($newTotal > 1.0001) {
            return redirect()->back()->withInput()->with('error', 'Total bobot tidak boleh lebih dari 1. Perbaiki nilai bobot atau hapus bobot lain terlebih dahulu.');
        }

        Kriteria::create($request->all());
        $message = $newTotal == 1.0
            ? 'Kriteria bobot berhasil ditambahkan.'
            : 'Kriteria bobot tersimpan. Total bobot belum 1. Tambahkan kriteria lain agar total = 1.';

        return redirect()->route('bobot.index')->with('success', $message);
    }

    public function edit(Kriteria $bobot)
    {
        return view('bobot.edit', compact('bobot'));
    }

    public function update(Request $request, Kriteria $bobot)
    {
        $request->validate([
            'kode'      => 'required|unique:kriteria,kode,' . $bobot->id,
            'kriteria'  => 'required',
            'tipe'      => 'required|in:benefit,cost',
            'bobot'     => 'required|numeric|min:0|max:1',
            'keterangan'=> 'nullable',
        ]);

        $newTotal = $this->currentKriteriaTotal($bobot->id) + (float) $request->input('bobot');
        if ($newTotal > 1.0001) {
            return redirect()->back()->withInput()->with('error', 'Total bobot tidak boleh lebih dari 1. Perbaiki nilai bobot atau hapus bobot lain terlebih dahulu.');
        }

        $bobot->update($request->all());
        $message = $newTotal == 1.0
            ? 'Kriteria bobot berhasil diperbarui.'
            : 'Kriteria bobot diperbarui. Total bobot belum 1. Tambahkan kriteria lain agar total = 1.';

        return redirect()->route('bobot.index')->with('success', $message);
    }

    public function destroy(Kriteria $bobot)
    {
        $bobot->delete();
        return redirect()->route('bobot.index')->with('success', 'Bobot berhasil dihapus.');
    }
}
