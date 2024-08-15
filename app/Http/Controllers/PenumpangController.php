<?php

namespace App\Http\Controllers;

use App\Models\Penumpang;
use App\Models\Travel;
use Illuminate\Http\Request;

class PenumpangController extends Controller
{
    public function create()
    {
        $travels = Travel::where('tanggal_keberangkatan', '>', now())
            ->where('kuota', '>', 0)
            ->get();
        return view('penumpang.create', compact('travels'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'id_travel' => 'required|exists:travel,id',
            'data_penumpang' => 'required|string',
            'jenis_kelamin' => 'required|string',
        ]);
        
        // $data = ['alvina 21 malang'];
        $data = explode(' ', $request->input('data_penumpang'));

        $indeksUsia = -1;
        foreach ($data as $index => $value) {
            if (is_numeric($value)) {
                $indeksUsia = $index;
                break;
            }
        }

        if ($indeksUsia === -1 || count($data) < $indeksUsia + 2) {
            return redirect()->back()->with('error', 'Format input tidak valid. Gunakan format: NAMA USIA KOTA');
        }

        $nama = implode(' ', array_slice($data, 0, $indeksUsia));
        // dd($nama);
        $usia = $this->parseUsia($data[$indeksUsia]);
        // dd($usia);
        $kota = implode(' ', array_slice($data, $indeksUsia + 1));
        // dd($kota);
        $tahunLahir = now()->year - $usia;

        $nama = strtoupper(trim($nama));
        $kota = strtoupper(trim($kota));

        $travel = Travel::find($request->input('id_travel'));

        if ($travel->kuota <= 0) {
            return redirect()->back()->with('error', 'Kuota untuk perjalanan ini sudah habis.');
        }

        $existingPenumpang = Penumpang::where('id_travel', $request->input('id_travel'))
            ->where('nama', $nama)
            ->where('usia', $usia)
            ->where('kota', $kota)
            ->first();
        if ($existingPenumpang) {
            return redirect()->back()->with('error', 'Penumpang yang sama sudah terdaftar di perjalanan ini.');
        }

        $kodeBooking = $this->generateKodeBooking($travel->id);
        // dd($kodeBooking);


        Penumpang::create([
            'id_travel' => $request->input('id_travel'),
            'kode_booking' => $kodeBooking,
            'nama' => $nama,
            'usia' => $usia,
            'kota' => $kota,
            'tahun_lahir' => $tahunLahir,
            'jenis_kelamin' => $request->input('jenis_kelamin'),
        ]);

        $travel->decrement('kuota');

        return redirect()->route('penumpang.create')->with('success', 'Penumpang berhasil ditambahkan.');
    }

    private function parseUsia($usiaInput)
    {
        // dd($usiaInput);
        // Menghapus spasi dan mengkonversi ke format uppercase
        $usiaInput = strtoupper(trim($usiaInput));

        // Menggunakan regex untuk mengekstrak usia
        if (preg_match('/^(\d+)\s*(TAHUN|THN|TH)$/', $usiaInput, $matches)) {
            return (int)$matches[1];
        }

        if (is_numeric($usiaInput)) {
            return (int) $usiaInput;
        }

        return null;
    }

    private function generateKodeBooking($idTravel)
    {
        $prefix = now()->format('y') . now()->format('m');
        $travelId = str_pad($idTravel, 4, '0', STR_PAD_LEFT);
        $penumpangCount = Penumpang::where('id_travel', $idTravel)->count() + 1;
        $sequence = str_pad($penumpangCount, 4, '0', STR_PAD_LEFT);

        return $prefix . $travelId . $sequence;
    }
}
