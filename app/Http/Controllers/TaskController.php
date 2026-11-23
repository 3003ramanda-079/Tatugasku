<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Pengguna;
use App\Models\Task;
use Illuminate\Http\Request;

// Anggota 4: tabel tasks + integrasi
class TaskController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter');
        if (! in_array($filter, ['belum', 'selesai'], true)) {
            $filter = 'semua';
        }

        $tasks = Task::with(['mataKuliah', 'pengguna'])
            ->when($filter !== 'semua', fn ($q) => $q->where('status', $filter))
            ->orderBy('status')       // "belum" tampil sebelum "selesai"
            ->orderBy('deadline')
            ->get();

        $stat = [
            'total'   => Task::count(),
            'belum'   => Task::where('status', 'belum')->count(),
            'selesai' => Task::where('status', 'selesai')->count(),
            'lewat'   => Task::where('status', 'belum')->whereDate('deadline', '<', now()->toDateString())->count(),
        ];

        return view('tugas.index', [
            'tasks'  => $tasks,
            'stat'   => $stat,
            'filter' => $filter,
            'users'  => Pengguna::orderBy('nama')->get(),
            'matkul' => MataKuliah::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'   => 'required|exists:pengguna,id',
            'matkul_id' => 'required|exists:mata_kuliah,id',
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline'  => 'required|date',
        ], [
            'user_id.required'   => 'Pengguna wajib dipilih.',
            'matkul_id.required' => 'Mata kuliah wajib dipilih.',
            'judul.required'     => 'Judul tugas wajib diisi.',
            'deadline.required'  => 'Deadline wajib diisi.',
            'deadline.date'      => 'Format deadline tidak valid.',
        ]);

        $task = Task::create($data);
        $task->buatPengingat();

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function status(Request $request, Task $task)
    {
        $aksi = $request->input('aksi');

        if ($aksi === 'selesai') {
            $task->update(['status' => 'selesai']);
        } elseif ($aksi === 'batal') {
            $task->update(['status' => 'belum']);
        }

        return back();
    }

    public function destroy(Task $task)
    {
        $task->delete(); // pengingat ikut terhapus (cascade)

        return back()->with('success', 'Tugas berhasil dihapus.');
    }
}
