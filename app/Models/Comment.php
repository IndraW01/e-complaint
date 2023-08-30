<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'mahasiswa_id',
        'pengaduan_id',
        'pesan'
    ];

    // Relasi
    public function Pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
