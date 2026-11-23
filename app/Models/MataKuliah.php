<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $table = 'mata_kuliah';

    protected $fillable = ['nama', 'dosen', 'semester'];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'matkul_id');
    }
}
