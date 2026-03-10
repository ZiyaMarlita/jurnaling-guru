<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'role',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* =========================
       RELASI
    ========================= */

    public function guru()
    {
        return $this->hasOne(Guru::class, 'user_id');
    }

    // Relasi ke evaluasi yang dibuat kepsek ini
    public function evaluasi()
    {
        return $this->hasMany(Evaluasi::class, 'kepsek_id');
    }
}