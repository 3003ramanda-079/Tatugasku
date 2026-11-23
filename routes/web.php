<?php

use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PengingatController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Tugas (Anggota 4)
Route::get('/', [TaskController::class, 'index'])->name('tugas.index');
Route::post('/tugas', [TaskController::class, 'store'])->name('tugas.store');
Route::patch('/tugas/{task}/status', [TaskController::class, 'status'])->name('tugas.status');
Route::delete('/tugas/{task}', [TaskController::class, 'destroy'])->name('tugas.destroy');

// Pengguna (Anggota 1)
Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
Route::delete('/pengguna/{pengguna}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

// Mata kuliah (Anggota 2)
Route::get('/mata-kuliah', [MataKuliahController::class, 'index'])->name('matkul.index');
Route::post('/mata-kuliah', [MataKuliahController::class, 'store'])->name('matkul.store');
Route::delete('/mata-kuliah/{mataKuliah}', [MataKuliahController::class, 'destroy'])->name('matkul.destroy');

// Pengingat (Anggota 3)
Route::get('/pengingat', [PengingatController::class, 'index'])->name('pengingat.index');
Route::patch('/pengingat/{reminder}', [PengingatController::class, 'tandai'])->name('pengingat.tandai');
