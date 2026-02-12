<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|integer',
        ]);

        Kriteria::create($request->all());

        return redirect()->route('penilaian.create')->with('success', 'Kriteria berhasil ditambah!');
    }
}