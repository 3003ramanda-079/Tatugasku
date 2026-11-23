<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'pengguna';

    protected $fillable = ['nama', 'email'];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id');
    }
}
