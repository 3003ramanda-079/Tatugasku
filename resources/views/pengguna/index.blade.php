@extends('layouts.app')
@section('judul', 'Pengguna')

@section('isi')
    <div class="card">
        <h2>👤 Tambah Pengguna</h2>
        <form action="{{ route('pengguna.store') }}" method="post">
            @csrf
            <div class="form-row">
                <div class="form-group"><label for="nama">Nama</label><input type="text" id="nama" name="nama" value="{{ old('nama') }}" required></div>
                <div class="form-group"><label for="email">Email</label><input type="text" id="email" name="email" value="{{ old('email') }}" required></div>
            </div>
            <button type="submit" class="btn-submit">Simpan Pengguna</button>
        </form>
    </div>
    <div class="card">
        <h2>Daftar Pengguna</h2>
        <table class="simple">
            <tr><th>Nama</th><th>Email</th><th>Jml Tugas</th><th></th></tr>
            @foreach ($users as $u)
                <tr>
                    <td>{{ $u->nama }}</td><td>{{ $u->email }}</td><td>{{ $u->tasks_count }}</td>
                    <td>
                        <form action="{{ route('pengguna.destroy', $u) }}" method="post" onsubmit="return confirm('Hapus pengguna ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn-small btn-delete" type="submit">🗑 Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
