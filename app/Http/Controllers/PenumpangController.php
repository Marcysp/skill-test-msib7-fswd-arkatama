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

        // Mengurai input data_penumpang
        $data = explode(' ', $request->input('data_penumpang'));
        if (count($data) < 2) {
            return redirect()->back()->with('error', 'Format input tidak valid. Gunakan format: NAMA USIA KOTA');
        }
        // dd($data);
        // $data = ['alvina 21 malang'];

        $usia = $this->parseUsia(array_pop($data));
        dd($usia);
        if ($usia === null) {
            return redirect()->back()->with('error', 'Format usia tidak valid. Gunakan format: 28 TAHUN, 28 THN, atau 28 TH');
        }

        $nama = strtoupper(implode(' ', $data));
        $kota = strtoupper(array_pop($data));
        $tahunLahir = now()->year - $usia;

        // Mendapatkan travel yang dipilih
        $travel = Travel::find($request->input('id_travel'));

        if ($travel->kuota <= 0) {
            return redirect()->back()->with('error', 'Kuota untuk perjalanan ini sudah habis.');
        }

        $existingPenumpang = Penumpang::where('id_travel', $request->input('id_travel'))
                                      ->where('nama', $nama)
                                      ->where('usia',$usia)
                                      ->where('kota',$kota)
                                      ->first();
        if ($existingPenumpang) {
            return redirect()->back()->with('error', 'Penumpang yang sama sudah terdaftar di perjalanan ini.');
        }

        $kodeBooking = $this->generateKodeBooking($travel->id);
        dd($kodeBooking);

        // Membuat penumpang baru
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
        $prefix = now()->format('y') . now()->format('m'); // 2 digit tahun dan 2 digit bulan
        $travelId = str_pad($idTravel, 4, '0', STR_PAD_LEFT); // 4 digit id travel
        $penumpangCount = Penumpang::where('id_travel', $idTravel)->count() + 1; // Nomor urut
        $sequence = str_pad($penumpangCount, 4, '0', STR_PAD_LEFT); // 4 digit nomor urut

        return $prefix . $travelId . $sequence;
    }
}
