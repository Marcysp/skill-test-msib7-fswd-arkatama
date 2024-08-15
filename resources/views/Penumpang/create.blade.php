@extends('welcome')

@section('content')
    <h1>Tambah Penumpang</h1>

    <form action="{{ route('penumpang.store') }}" method="POST">
        @csrf

        <div>
            <label for="id_travel">Pilih Perjalanan:</label>
            <select name="id_travel" id="id_travel" required>
                @foreach($travels as $travel)
                    <option value="{{ $travel->id }}">{{ $travel->tanggal_keberangkatan }} - Kuota: {{ $travel->kuota }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="data_penumpang">Nama, Usia, Kota (Format: NAMA USIA KOTA):</label>
            <input type="text" name="data_penumpang" id="data_penumpang" required />
        </div>

        <div>
            <label for="jenis_kelamin">Jenis Kelamin:</label>
            <select name="jenis_kelamin" id="jenis_kelamin" required>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <button type="submit">Simpan</button>
    </form>
@endsection
