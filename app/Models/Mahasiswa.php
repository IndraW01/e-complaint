<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jurusan_id',
        'nim',
    ];

    // Relasi
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function Tiket(): HasOne
    {
        return $this->hasOne(Tiket::class);
    }
}
