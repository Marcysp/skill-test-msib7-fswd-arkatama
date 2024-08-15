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
            <label for="kode_booking">Kode Booking:</label>
            <input type="text" name="kode_booking" id="kode_booking" required />
        </div>

        <div>
            <label for="nama">Nama:</label>
            <input type="text" name="nama" id="nama" required />
        </div>

        <div>
            <label for="jenis_kelamin">Jenis Kelamin:</label>
            <select name="jenis_kelamin" id="jenis_kelamin" required>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <div>
            <label for="kota">Kota:</label>
            <input type="text" name="kota" id="kota" required />
        </div>

        <div>
            <label for="usia">Usia:</label>
            <input type="number" name="usia" id="usia" required />
        </div>

        <div>
            <label for="tahun_lahir">Tahun Lahir:</label>
            <input type="number" name="tahun_lahir" id="tahun_lahir" required />
        </div>

        <button type="submit">Simpan</button>
    </form>
@endsection
