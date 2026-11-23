<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

// Anggota 1: tabel pengguna
class PenggunaController extends Controller
{
    public function index()
    {
        return view('pengguna.index', [
            'users' => Pengguna::withCount('tasks')->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
        ], [
            'nama.required'  => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Email harus valid.',
            'email.unique'   => 'Email sudah terdaftar.',
        ]);

        Pengguna::create($request->only('nama', 'email'));

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function destroy(Pengguna $pengguna)
    {
        // Pengguna yang masih punya tugas tidak boleh dihapus
        if ($pengguna->tasks()->exists()) {
            return back()->with('error', 'Pengguna masih memiliki tugas, hapus tugasnya terlebih dahulu.');
        }

        $pengguna->delete();

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
