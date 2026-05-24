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
        $kriteria = Kriteria::orderBy('id')->get();
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
            'nama_kriteria' => 'required|unique:kriterias,nama_kriteria',
            'atribut'       => 'required|in:benefit,cost',
            'bobot'         => 'required|numeric|min:0|max:1',
        ]);

        $newTotal = $this->currentKriteriaTotal() + (float) $request->input('bobot');
        if ($newTotal > 1.0001) {
            return redirect()->back()->withInput()->with('error', 'Total bobot tidak boleh lebih dari 1. Perbaiki nilai bobot atau hapus kriteria lain terlebih dahulu.');
        }

        Kriteria::create($request->only(['nama_kriteria', 'atribut', 'bobot']));
        $message = $newTotal == 1.0
            ? 'Kriteria berhasil ditambahkan.'
            : 'Kriteria tersimpan. Total bobot belum 1. Tambahkan kriteria lain agar total = 1.';

        return redirect()->route('bobot.index')->with('success', $message);
    }

    public function edit(Kriteria $bobot)
    {
        return view('bobot.edit', compact('bobot'));
    }

    public function update(Request $request, Kriteria $bobot)
    {
        $request->validate([
            'nama_kriteria' => 'required|unique:kriterias,nama_kriteria,' . $bobot->id,
            'atribut'       => 'required|in:benefit,cost',
            'bobot'         => 'required|numeric|min:0|max:1',
        ]);

        $newTotal = $this->currentKriteriaTotal($bobot->id) + (float) $request->input('bobot');
        if ($newTotal > 1.0001) {
            return redirect()->back()->withInput()->with('error', 'Total bobot tidak boleh lebih dari 1. Perbaiki nilai bobot atau hapus kriteria lain terlebih dahulu.');
        }

        $bobot->update($request->only(['nama_kriteria', 'atribut', 'bobot']));
        $message = $newTotal == 1.0
            ? 'Kriteria berhasil diperbarui.'
            : 'Kriteria diperbarui. Total bobot belum 1. Tambahkan kriteria lain agar total = 1.';

        return redirect()->route('bobot.index')->with('success', $message);
    }

    public function destroy(Kriteria $bobot)
    {
        $bobot->delete();
        return redirect()->route('bobot.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}
