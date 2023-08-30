<?php

use App\Models\Role;
use App\Models\Kategori;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_kategori', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(Kategori::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Role::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unique(['kategori_id', 'role_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_kategori');
    }
};
