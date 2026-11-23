@extends('layouts.app')
@section('judul', 'Tugas')

@section('isi')
    <!-- Ringkasan -->
    <div class="summary-row">
        <div class="summary-box"><div class="num">{{ $stat['total'] }}</div><div class="lbl">Total Tugas</div></div>
        <div class="summary-box"><div class="num">{{ $stat['belum'] }}</div><div class="lbl">Belum Selesai</div></div>
        <div class="summary-box"><div class="num">{{ $stat['selesai'] }}</div><div class="lbl">Selesai</div></div>
        <div class="summary-box"><div class="num" style="color:#b91c1c">{{ $stat['lewat'] }}</div><div class="lbl">Lewat Deadline</div></div>
    </div>

    <!-- Form tambah tugas -->
    <div class="card">
        <h2>➕ Tambah Tugas Baru</h2>
        <form action="{{ route('tugas.store') }}" method="post">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="matkul_id">Mata Kuliah</label>
                    <select id="matkul_id" name="matkul_id" required>
                        <option value="">-- pilih --</option>
                        @foreach ($matkul as $m)
                            <option value="{{ $m->id }}" @selected(old('matkul_id') == $m->id)>{{ $m->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="user_id">Pengguna</label>
                    <select id="user_id" name="user_id" required>
                        @foreach ($users as $u)
                            <option value="{{ $u->id }}" @selected(old('user_id') == $u->id)>{{ $u->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="deadline">Deadline</label>
                    <input type="date" id="deadline" name="deadline" value="{{ old('deadline') }}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="judul">Judul Tugas</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Makalah ekosistem startup" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi (opsional)</label>
                <textarea id="deskripsi" name="deskripsi" placeholder="Catatan tambahan...">{{ old('deskripsi') }}</textarea>
            </div>
            <button type="submit" class="btn-submit">Simpan Tugas</button>
        </form>
    </div>

    <!-- Daftar tugas -->
    <div class="tabs">
        <a class="tab {{ $filter === 'semua' ? 'active' : '' }}" href="{{ route('tugas.index') }}">Semua</a>
        <a class="tab {{ $filter === 'belum' ? 'active' : '' }}" href="{{ route('tugas.index', ['filter' => 'belum']) }}">Belum Selesai</a>
        <a class="tab {{ $filter === 'selesai' ? 'active' : '' }}" href="{{ route('tugas.index', ['filter' => 'selesai']) }}">Selesai</a>
    </div>

    <div class="card">
        <h2>📋 Daftar Tugas</h2>

        @if ($tasks->isEmpty())
            <div class="empty-state">
                Belum ada tugas. Tambahkan tugas pertamamu di atas! 🎉
                @if ($matkul->isEmpty())
                    Tambahkan dulu <a href="{{ route('matkul.index') }}">mata kuliah</a>.
                @endif
            </div>
        @endif

        @foreach ($tasks as $t)
            @php $urg = $t->urgensi(); @endphp
            <div class="task-item {{ $t->status === 'selesai' ? 'selesai' : '' }}">
                <div class="task-main">
                    <div class="matkul">{{ $t->mataKuliah->nama }} · {{ $t->pengguna->nama }}</div>
                    <div class="judul">{{ $t->judul }}</div>
                    @if ($t->deskripsi)
                        <div class="deskripsi">{{ $t->deskripsi }}</div>
                    @endif
                    <div class="deadline">
                        ⏰ {{ \App\Support\Tanggal::indo($t->deadline) }}
                        <span class="badge {{ $urg['class'] }}">{{ $urg['label'] }}</span>
                    </div>
                </div>
                <div class="task-actions">
                    <form action="{{ route('tugas.status', $t) }}" method="post">
                        @csrf
                        @method('PATCH')
                        @if ($t->status === 'selesai')
                            <input type="hidden" name="aksi" value="batal">
                            <button class="btn-small btn-undo" type="submit">↩ Batalkan</button>
                        @else
                            <input type="hidden" name="aksi" value="selesai">
                            <button class="btn-small btn-done" type="submit">✔ Selesai</button>
                        @endif
                    </form>
                    <form action="{{ route('tugas.destroy', $t) }}" method="post" onsubmit="return confirm('Hapus tugas ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn-small btn-delete" type="submit">🗑 Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
