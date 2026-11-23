<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel 3: tasks (Anggota 4)
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('pengguna');
            $table->foreignId('matkul_id')->constrained('mata_kuliah');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->date('deadline');
            $table->string('status')->default('belum'); // belum | selesai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
