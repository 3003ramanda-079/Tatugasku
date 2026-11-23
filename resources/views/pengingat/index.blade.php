@extends('layouts.app')
@section('judul', 'Pengingat')

@section('isi')
    <div class="card">
        <h2>🔔 Pengingat Hari Ini ({{ $jatuhTempo->count() }})</h2>
        @if ($jatuhTempo->isEmpty())
            <div class="empty-state">Tidak ada pengingat yang jatuh tempo. 🎉</div>
        @endif
        @foreach ($jatuhTempo as $r)
            <div class="task-item">
                <div class="task-main">
                    <div class="matkul">{{ $r->task->mataKuliah->nama }} · {{ $r->task->pengguna->nama }}</div>
                    <div class="judul">{{ $r->task->judul }}</div>
                    <div class="deadline">⏰ Deadline {{ \App\Support\Tanggal::indo($r->task->deadline) }}
                        <span class="badge badge-dekat">{{ $r->jenis }}</span></div>
                </div>
                <div class="task-actions">
                    <form action="{{ route('pengingat.tandai', $r) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <button class="btn-small btn-done" type="submit">✔ Tandai Terkirim</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    <div class="card">
        <h2>Jadwal Semua Pengingat</h2>
        <table class="simple">
            <tr><th>Tanggal</th><th>Jenis</th><th>Tugas</th><th>Mata Kuliah</th><th>Status</th></tr>
            @foreach ($semua as $r)
                <tr>
                    <td>{{ \App\Support\Tanggal::indo($r->tanggal_kirim) }}</td><td>{{ $r->jenis }}</td>
                    <td>{{ $r->task->judul }}</td><td>{{ $r->task->mataKuliah->nama }}</td>
                    <td>{{ $r->sudah_dikirim ? 'Terkirim' : 'Menunggu' }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
