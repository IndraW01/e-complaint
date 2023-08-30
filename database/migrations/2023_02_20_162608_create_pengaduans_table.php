<?php

use App\Models\Kategori;
use App\Models\Tiket;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(Tiket::class)->unique()->constrained();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->string('status')->default('pending');
            $table->integer('rating')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
