<?php

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
        Schema::create('alat_labs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_alat');
            $table->string('id_alat')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->integer('stok')->default();
            $table->string('kualitas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat_labs');
    }
};
