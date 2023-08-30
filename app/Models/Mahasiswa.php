<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mahasiswa extends Authenticatable
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'jurusan_id',
        'name',
        'password',
        'nim',
        'email',
        'angkatan',
        'foto',
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

    public function Tiket(): HasMany
    {
        return $this->hasMany(Tiket::class);
    }

    public function Comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function PengaduanNotification(): HasMany
    {
        return $this->hasMany(PengaduanNotification::class);
    }

    // Accessor / Mutator
    public function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Hash::make($value),
        );
    }

    // Scope Function
    public function scopeSearch(Builder $query, $keywords = null)
    {
        if (!empty($keywords)) {
            $query->when($keywords->searchMahasiswa, function (Builder $query, $keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
            });
            $query->when($keywords->searchJurusan, function (Builder $query, $keyword) {
                $query->whereHas('Jurusan', function (Builder $query) use ($keyword) {
                    $query->where('jurusans.name', $keyword);
                });
            });
            $query->when($keywords->searchAngkatan, function (Builder $query, $keyword) {
                $query->where('angkatan', $keyword);
            });
        }
    }
}
