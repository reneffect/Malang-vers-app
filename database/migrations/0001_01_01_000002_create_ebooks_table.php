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
        Schema::create('buku_digital', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            $table->string('kode_url', 220)->unique();
            $table->string('penulis', 150)->nullable();
            $table->string('kategori', 100)->default('umum'); // Ditambahkan untuk filter
            $table->string('lokasi_sampul', 255)->nullable();
            $table->string('lokasi_pratinjau', 255)->nullable();
            $table->string('lokasi_berkas', 255);
            $table->integer('jumlah_halaman')->nullable();
            $table->integer('terjual')->default(0); // Ditambahkan untuk sorting orderBy
            $table->decimal('harga', 12, 2)->default(0)->comment('Harga 0 berarti gratis; akses tetap khusus Member');
            $table->boolean('sudah_diterbitkan')->default(false); // Ini pengganti is_active
            $table->boolean('is_bundle')->default(false); // Ditambahkan untuk fitur bundle
            $table->timestamps(); // Ini otomatis membuat created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_digital');
    }
};
