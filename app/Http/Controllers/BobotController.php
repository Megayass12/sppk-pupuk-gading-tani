<?php

namespace App\Http\Controllers;

use App\Models\Bobot;
use Illuminate\Http\Request;

class BobotController extends Controller
{
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

        Bobot::create($request->all());
        return redirect()->route('bobot.index')->with('success', 'Kriteria bobot berhasil ditambahkan.');
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

        $bobot->update($request->all());
        return redirect()->route('bobot.index')->with('success', 'Bobot berhasil diperbarui.');
    }

    public function destroy(Bobot $bobot)
    {
        $bobot->delete();
        return redirect()->route('bobot.index')->with('success', 'Bobot berhasil dihapus.');
    }
}
