<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Traits\Accessors\RoleNameTitle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, RoleNameTitle, HasUuids;

    protected $fillable = [
        'name',
        'slug'
    ];

    // Relasi
    public function Users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function RoleKategori(): HasOne
    {
        return $this->hasOne(RoleKategori::class, 'role_id', 'id');
    }

    public static function booted(): void
    {
        static::creating(function (Role $role) {
            $role->slug = Str::slug($role->name);
        });
    }
}
