<?php

namespace App\Http\Controllers;

use App\Models\Reminder;

// Anggota 3: tabel reminders
class PengingatController extends Controller
{
    public function index()
    {
        return view('pengingat.index', [
            'jatuhTempo' => Reminder::jatuhTempo()->with('task.mataKuliah', 'task.pengguna')->orderBy('tanggal_kirim')->get(),
            'semua'      => Reminder::aktif()->with('task.mataKuliah')->orderBy('tanggal_kirim')->get(),
        ]);
    }

    public function tandai(Reminder $reminder)
    {
        $reminder->update(['sudah_dikirim' => true]);

        return redirect()->route('pengingat.index');
    }
}
