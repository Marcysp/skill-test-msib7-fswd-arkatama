@extends('welcome')

@section('content')
<h1>Tambah Perjalanan</h1>
<form action="{{ route('travel.store') }}" method="POST">
    @csrf

    <label for="tanggal_keberangkatan">Tanggal Keberangkatan:</label>
    <input type="datetime-local" id="tanggal_keberangkatan" name="tanggal_keberangkatan" required>
    <br>

    <label for="kuota">Kuota:</label>
    <input type="number" id="kuota" name="kuota" min="1" required>
    <br>

    <button type="submit">Simpan</button>
</form>

<a href="{{ route('travel.index') }}">Kembali ke Daftar Perjalanan</a>
@endsection
