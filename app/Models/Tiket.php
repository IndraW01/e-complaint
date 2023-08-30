<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tiket extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'mahasiswa_id',
        'token',
    ];

    // Relasi
    public function Mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function Pengaduan(): HasOne
    {
        return $this->hasOne(Pengaduan::class);
    }
}
