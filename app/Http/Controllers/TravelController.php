<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    public function index()
    {
        // Ambil semua data travel dari database
        $travels = Travel::all();

        // Tampilkan halaman view dan kirimkan data travel ke view
        return view('travel.show-travel', compact('travels'));
    }

    public function create()
    {
        return view('travel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_keberangkatan' => 'required|date',
            'kuota' => 'required|integer',
        ]);

        // Travel::create($request->all());
        Travel::create([
            'tanggal_keberangkatan' => $request->input('tanggal_keberangkatan'),
            'kuota' => $request->input('kuota'),
        ]);
        return redirect()->route('travel.index')->with('success', 'Perjalanan berhasil ditambahkan.');
        // return redirect()->route('travel.index');
    }

    public function edit($id)
    {
        $travel = Travel::findOrFail($id);
        $travel->tanggal_keberangkatan = \Carbon\Carbon::parse($travel->tanggal_keberangkatan);
        return view('travel.edit', compact('travel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_keberangkatan' => 'required|date',
            'kuota' => 'required|integer',
        ]);

        $travel = Travel::findOrFail($id);
        $travel->update($request->all());
        return redirect()->route('travel.index');
    }

    public function destroy($id)
    {
        $travel = Travel::findOrFail($id);
        $travel->delete();
        return redirect()->route('travel.index');
    }
}
