<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pengaduan_id',
        'pesan'
    ];

    // Relasi
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class);
    }
}
