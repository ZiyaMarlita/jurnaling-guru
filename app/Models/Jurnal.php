<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 'jurnal';

    protected $fillable = [
        'guru_id',
        'tanggal',
        'jam_pelajaran',
        'mata_pelajaran',
        'kelas',
        'materi',
        'kendala',
        'status',
        // FIX: kolom 'nilai' dihapus dari sini
        // Nilai disimpan di tabel 'evaluasi', akses via $jurnal->evaluasi->nilai
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /* =========================
       RELASI
    ========================= */

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function evaluasi()
    {
        return $this->hasOne(Evaluasi::class, 'jurnal_id');
    }

    /* =========================
       LOCAL SCOPES
       Penggunaan: Jurnal::pending()->get()
    ========================= */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDinilai($query)
    {
        return $query->where('status', 'dinilai');
    }

    public function scopeRevisi($query)
    {
        return $query->where('status', 'revisi');
    }
}