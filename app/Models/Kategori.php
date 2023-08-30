<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kategori extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug'
    ];

    // Relasi
    public function Pengaduans(): BelongsToMany
    {
        return $this->belongsToMany(Pengaduan::class);
    }

    public function RoleKategori(): HasOne
    {
        return $this->hasOne(RoleKategori::class, 'kategori_id', 'id');
    }
}
