<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel 4: reminders (Anggota 3). Hapus tugas = pengingatnya ikut terhapus.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            $table->string('jenis');            // H-3 | H-1 | Hari-H
            $table->date('tanggal_kirim');
            $table->boolean('sudah_dikirim')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
