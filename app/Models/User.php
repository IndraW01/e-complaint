<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'jenis_kelamin',
        'foto',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi
    public function Role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function Mahasiswa(): HasOne
    {
        return $this->hasOne(Mahasiswa::class);
    }

    public function Comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // Accessor / Mutator
    public function jenisKelamin(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value == 'laki' ? 'Laki - Laki' : 'Perempuan',
        );
    }

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
            $query->when($keywords->searchUser, function (Builder $query, $keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
            });
            $query->when($keywords->searchRole, function (Builder $query, $keyword) {
                $query->whereHas('Role', function (Builder $query) use ($keyword) {
                    $query->where('name', $keyword);
                });
            });
        }
    }
}
