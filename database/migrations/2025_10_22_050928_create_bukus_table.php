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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('judul buku');
            $table->string('penulis')->nullable();
            $table->string('penerbit')->nullable();
            $table->year('tahun_terbit')->nullable();
            $table->string('isbn')->nullable()->unique();
            $table->integer('halaman')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->integer('stok')->default(0);
            $table->string('kategori');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
