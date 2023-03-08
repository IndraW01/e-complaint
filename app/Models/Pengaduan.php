<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tiket_id',
        'title',
        'slug',
        'deskripsi',
        'status',
        'rating'
    ];

    // Relasi
    public function Tiket(): BelongsTo
    {
        return $this->belongsTo(Tiket::class);
    }

    public function Kategoris(): BelongsToMany
    {
        return $this->belongsToMany(Kategori::class);
    }
}
