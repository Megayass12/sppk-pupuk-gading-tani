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
        $totalKriteria = Kriteria::sum('bobot');
        $availableBobot = 1.0 - $totalKriteria;
        return view('bobot.create', compact('totalKriteria', 'availableBobot'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|unique:kriterias,nama_kriteria',
            'atribut'       => 'required|in:benefit,cost',
            'bobot'         => 'required|numeric|min:0|max:100',
        ]);

        // Convert percentage to decimal
        $bobot = (float) $request->input('bobot') / 100;

        $newTotal = $this->currentKriteriaTotal() + $bobot;
        if ($newTotal > 1.0001) {
            return redirect()->back()->withInput()->with('error', 'Total bobot tidak boleh lebih dari 100%. Perbaiki nilai bobot atau hapus kriteria lain terlebih dahulu.');
        }

        Kriteria::create([
            'nama_kriteria' => $request->input('nama_kriteria'),
            'atribut' => $request->input('atribut'),
            'bobot' => $bobot,
        ]);
        $message = $newTotal == 1.0
            ? 'Kriteria berhasil ditambahkan. Total bobot = 100%.'
            : 'Kriteria berhasil ditambahkan. Total bobot belum 100%. Tambahkan kriteria lain agar total = 100%.';

        return redirect()->route('bobot.index')->with('success', $message);
    }

    public function edit(Kriteria $bobot)
    {
        $totalKriteria = Kriteria::sum('bobot');
        $availableBobot = 1.0 - $totalKriteria + $bobot->bobot; // Add back current bobot to available amount
        return view('bobot.edit', compact('bobot', 'totalKriteria', 'availableBobot'));
    }

    public function update(Request $request, Kriteria $bobot)
    {
        $request->validate([
            'nama_kriteria' => 'required|unique:kriterias,nama_kriteria,' . $bobot->id,
            'atribut'       => 'required|in:benefit,cost',
            'bobot'         => 'required|numeric|min:0|max:100',
        ]);

        // Convert percentage to decimal
        $bobotDecimal = (float) $request->input('bobot') / 100;

        $newTotal = $this->currentKriteriaTotal($bobot->id) + $bobotDecimal;
        if ($newTotal > 1.0001) {
            return redirect()->back()->withInput()->with('error', 'Total bobot tidak boleh lebih dari 100%. Perbaiki nilai bobot atau hapus kriteria lain terlebih dahulu.');
        }

        $bobot->update([
            'nama_kriteria' => $request->input('nama_kriteria'),
            'atribut' => $request->input('atribut'),
            'bobot' => $bobotDecimal,
        ]);
        $message = $newTotal == 1.0
            ? 'Kriteria berhasil diperbarui. Total bobot = 100%.'
            : 'Kriteria berhasil diperbarui. Total bobot belum 100%. Tambahkan kriteria lain agar total = 100%.';

        return redirect()->route('bobot.index')->with('success', $message);
    }

    public function destroy(Kriteria $bobot)
    {
        $bobot->delete();
        return redirect()->route('bobot.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}
