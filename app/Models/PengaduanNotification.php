<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengaduanNotification extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'mahasiswa_id',
        'pengaduan_id',
        'is_active'
    ];

    // Relasi
    public function Mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function Pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class);
    }
}
