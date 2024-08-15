@extends('welcome')

@section('content')
<h1>Edit Perjalanan</h1>
    <form action="{{ route('travel.update', $travel->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="tanggal_keberangkatan">Tanggal Keberangkatan:</label>
        <input type="datetime-local" id="tanggal_keberangkatan" name="tanggal_keberangkatan" value="{{ $travel->tanggal_keberangkatan->format('Y-m-d\TH:i') }}" required>
        <br>
        <label for="kuota">Kuota:</label>
        <input type="number" id="kuota" name="kuota" value="{{ $travel->kuota }}" required>
        <br>
        <button type="submit">Update</button>
    </form>
@endsection
