<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Pengaduan extends Model
{
    use HasFactory, HasUuids;

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

    public function Comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function FotoPengaduans(): HasMany
    {
        return $this->hasMany(FotoPengaduan::class);
    }

    public function PengaduanNotification(): HasOne
    {
        return $this->hasOne(PengaduanNotification::class);
    }

    // Accessor & Mutator
    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::create($value)->diffForHumans()
        );
    }

    public function tanggalPengaduan(): Attribute
    {
        return Attribute::make(
            get: fn () => \Carbon\Carbon::parse($this->created_at)->isoFormat('YYYY-MM-DD')
        );
    }

    // Scope Function
    public function scopeSearch(Builder $query, $keywords = null)
    {
        if (!empty($keywords)) {
            $query->when($keywords->searchMahasiswa, function (Builder $query, $keyword) {
                $query->whereHas('Tiket.Mahasiswa', function (Builder $query) use ($keyword) {
                    $query->where('mahasiswas.name', 'LIKE', '%' . $keyword . '%');
                });
            });
            $query->when($keywords->searchJurusan, function (Builder $query, $keyword) {
                $query->whereHas('Tiket.Mahasiswa.Jurusan', function (Builder $query) use ($keyword) {
                    $query->where('jurusans.name', $keyword);
                });
            });
            $query->when($keywords->searchKategori, function (Builder $query, $keyword) {
                $query->whereHas('Kategoris', function (Builder $query) use ($keyword) {
                    $query->where('kategoris.name', $keyword);
                });
            });
            $query->when($keywords->searchStatus, function (Builder $query, $keyword) {
                $query->where('status', $keyword);
            });
        }
    }
    public function scopeRole(Builder $query)
    {
        if (Auth::guard('mahasiswa')->check() || Auth::guard('web')->user()->Role->name == 'Admin' || Auth::guard('web')->user()->Role->name == 'Superadmin') return;

        $query->whereHas('Kategoris', function (Builder $query) {
            $query->where('kategoris.name', Auth::guard('web')->user()->load(['Role' => ['RoleKategori' => ['Kategori']]])->Role->RoleKategori->Kategori->name);
        });
    }
}
