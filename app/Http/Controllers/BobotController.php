<?php

namespace App\Http\Controllers;

use App\Models\Bobot;
use Illuminate\Http\Request;

class BobotController extends Controller
{
    private function currentBobotTotal(?int $exceptId = null): float
    {
        return Bobot::when($exceptId, function ($query, $exceptId) {
            return $query->where('id', '!=', $exceptId);
        })->sum('bobot');
    }

    public function index()
    {
        $bobots = Bobot::all();
        $totalBobot = $bobots->sum('bobot');
        return view('bobot.index', compact('bobots', 'totalBobot'));
    }

    public function create()
    {
        return view('bobot.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'      => 'required|unique:bobots',
            'kriteria'  => 'required',
            'tipe'      => 'required|in:benefit,cost',
            'bobot'     => 'required|numeric|min:0|max:1',
            'keterangan'=> 'nullable',
        ]);

        $newTotal = $this->currentBobotTotal() + (float) $request->input('bobot');
        if ($newTotal > 1.0001) {
            return redirect()->back()->withInput()->with('error', 'Total bobot tidak boleh lebih dari 1. Perbaiki nilai bobot atau hapus bobot lain terlebih dahulu.');
        }

        Bobot::create($request->all());
        $message = $newTotal == 1.0
            ? 'Kriteria bobot berhasil ditambahkan.'
            : 'Kriteria bobot tersimpan. Total bobot belum 1. Tambahkan kriteria lain agar total = 1.';

        return redirect()->route('bobot.index')->with('success', $message);
    }

    public function edit(Bobot $bobot)
    {
        return view('bobot.edit', compact('bobot'));
    }

    public function update(Request $request, Bobot $bobot)
    {
        $request->validate([
            'kode'      => 'required|unique:bobots,kode,' . $bobot->id,
            'kriteria'  => 'required',
            'tipe'      => 'required|in:benefit,cost',
            'bobot'     => 'required|numeric|min:0|max:1',
            'keterangan'=> 'nullable',
        ]);

        $newTotal = $this->currentBobotTotal($bobot->id) + (float) $request->input('bobot');
        if ($newTotal > 1.0001) {
            return redirect()->back()->withInput()->with('error', 'Total bobot tidak boleh lebih dari 1. Perbaiki nilai bobot atau hapus bobot lain terlebih dahulu.');
        }

        $bobot->update($request->all());
        $message = $newTotal == 1.0
            ? 'Bobot berhasil diperbarui.'
            : 'Bobot diperbarui. Total bobot belum 1. Tambahkan kriteria lain agar total = 1.';

        return redirect()->route('bobot.index')->with('success', $message);
    }

    public function destroy(Bobot $bobot)
    {
        $bobot->delete();
        return redirect()->route('bobot.index')->with('success', 'Bobot berhasil dihapus.');
    }
}
