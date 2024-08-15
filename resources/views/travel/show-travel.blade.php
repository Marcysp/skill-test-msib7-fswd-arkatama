@extends('welcome')

@section('content')
<div class="container">
    <h1>Daftar Travel</h1>
    <a href="{{ route('travel.create') }}" class="btn btn-primary">Tambah Travel</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal Keberangkatan</th>
                <th>Kuota</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($travels as $travel)
            <tr>
                <td>{{ $travel->id }}</td>
                <td>{{ $travel->tanggal_keberangkatan }}</td>
                <td>{{ $travel->kuota }}</td>
                <td>
                    <a href="{{ route('travel.edit', $travel->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('travel.destroy', $travel->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
