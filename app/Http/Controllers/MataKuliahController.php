<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;

// Anggota 2: tabel mata_kuliah
class MataKuliahController extends Controller
{
    public function index()
    {
        return view('matkul.index', [
            'daftar' => MataKuliah::withCount('tasks')->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255|unique:mata_kuliah,nama',
            'dosen'    => 'nullable|string|max:255',
            'semester' => 'nullable|integer|min:1|max:14',
        ], [
            'nama.required'    => 'Nama mata kuliah wajib diisi.',
            'nama.unique'      => 'Mata kuliah sudah ada.',
            'semester.integer' => 'Semester harus berupa angka.',
        ]);

        MataKuliah::create($request->only('nama', 'dosen', 'semester'));

        return redirect()->route('matkul.index')->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function destroy(MataKuliah $mataKuliah)
    {
        // Mata kuliah yang masih dipakai tugas tidak boleh dihapus
        if ($mataKuliah->tasks()->exists()) {
            return back()->with('error', 'Mata kuliah masih dipakai oleh tugas, hapus tugasnya terlebih dahulu.');
        }

        $mataKuliah->delete();

        return redirect()->route('matkul.index')->with('success', 'Mata kuliah berhasil dihapus.');
    }
}
