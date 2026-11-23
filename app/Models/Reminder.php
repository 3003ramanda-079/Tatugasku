<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    public $timestamps = false;

    protected $fillable = ['task_id', 'jenis', 'tanggal_kirim', 'sudah_dikirim'];

    protected $casts = [
        'tanggal_kirim' => 'date',
        'sudah_dikirim' => 'boolean',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /** Hanya pengingat milik tugas yang belum selesai. */
    public function scopeAktif($query)
    {
        return $query->whereHas('task', fn ($q) => $q->where('status', 'belum'));
    }

    /** Pengingat yang tanggalnya sudah tiba dan belum ditandai terkirim. */
    public function scopeJatuhTempo($query)
    {
        return $query->aktif()
            ->where('sudah_dikirim', false)
            ->whereDate('tanggal_kirim', '<=', now()->toDateString());
    }
}
