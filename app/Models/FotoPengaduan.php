<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FotoPengaduan extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'pengaduan_id',
        'name',
        'isAdmin',
    ];

    // Relasi
    public function Pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class);
    }

    // Scope
    public function scopeFoto(Builder $query, $keyword)
    {
        return $query->where('isAdmin', $keyword)->get();
    }
}
