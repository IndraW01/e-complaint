<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoPengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengaduan_id',
        'name',
    ];

    // Relasi
    public function Pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class);
    }
}
