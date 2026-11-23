<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['user_id', 'matkul_id', 'judul', 'deskripsi', 'deadline', 'status'];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'matkul_id');
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

    /** Label urgensi berdasarkan sisa hari menuju deadline (H-3, H-1, hari-H, lewat). */
    public function urgensi(): array
    {
        if ($this->status === 'selesai') {
            return ['label' => 'Selesai', 'class' => 'badge-selesai'];
        }

        $hariIni = now()->startOfDay();
        $tenggat = $this->deadline->copy()->startOfDay();
        $selisih = (int) $hariIni->diffInDays($tenggat, false);

        if ($selisih < 0)   return ['label' => 'Lewat Deadline', 'class' => 'badge-lewat'];
        if ($selisih === 0) return ['label' => 'Deadline Hari Ini', 'class' => 'badge-hariini'];
        if ($selisih <= 3)  return ['label' => "H-{$selisih}", 'class' => 'badge-dekat'];

        return ['label' => "{$selisih} hari lagi", 'class' => 'badge-aman'];
    }

    /** Buat pengingat H-3, H-1, dan hari-H (tanggal yang sudah lewat dilewati). */
    public function buatPengingat(): void
    {
        $hariIni = now()->startOfDay();

        foreach (['H-3' => 3, 'H-1' => 1, 'Hari-H' => 0] as $jenis => $selisih) {
            $tanggal = $this->deadline->copy()->startOfDay()->subDays($selisih);
            if ($tanggal->greaterThanOrEqualTo($hariIni)) {
                $this->reminders()->create([
                    'jenis'         => $jenis,
                    'tanggal_kirim' => $tanggal->toDateString(),
                ]);
            }
        }
    }
}
