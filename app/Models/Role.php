<?php

namespace App\Models;

use App\Traits\Accessors\RoleNameTitle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory, RoleNameTitle;

    protected $fillable = [
        'name',
        'slug'
    ];

    // Relasi
    public function Users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
