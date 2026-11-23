@extends('layouts.app')
@section('judul', 'Mata Kuliah')

@section('isi')
    <div class="card">
        <h2>🎓 Tambah Mata Kuliah</h2>
        <form action="{{ route('matkul.store') }}" method="post">
            @csrf
            <div class="form-row">
                <div class="form-group"><label for="nama">Nama Mata Kuliah</label><input type="text" id="nama" name="nama" value="{{ old('nama') }}" required></div>
                <div class="form-group"><label for="dosen">Dosen</label><input type="text" id="dosen" name="dosen" value="{{ old('dosen') }}"></div>
                <div class="form-group"><label for="semester">Semester</label><input type="text" id="semester" name="semester" value="{{ old('semester') }}" inputmode="numeric"></div>
            </div>
            <button type="submit" class="btn-submit">Simpan Mata Kuliah</button>
        </form>
    </div>
    <div class="card">
        <h2>Daftar Mata Kuliah</h2>
        <table class="simple">
            <tr><th>Mata Kuliah</th><th>Dosen</th><th>Smt</th><th>Jml Tugas</th><th></th></tr>
            @foreach ($daftar as $m)
                <tr>
                    <td>{{ $m->nama }}</td><td>{{ $m->dosen }}</td>
                    <td>{{ $m->semester }}</td><td>{{ $m->tasks_count }}</td>
                    <td>
                        <form action="{{ route('matkul.destroy', $m) }}" method="post" onsubmit="return confirm('Hapus mata kuliah ini?');">
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
