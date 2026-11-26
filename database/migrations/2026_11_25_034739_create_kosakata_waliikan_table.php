<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kosakata_walikan', function (Blueprint $table) {
            $table->id();

            // === IDENTITAS UTAMA ===
            $table->string('kata_walikan', 50)->unique();
            $table->string('kata_asli', 50);
            $table->string('arti', 150);

            // === KLASIFIKASI BAHASA ===
            $table->enum('bahasa_asal', [
                'Jawa', 'Indonesia', 'Inggris', 'Arab', 'Campuran', 'Lainnya'
            ])->default('Jawa');

            $table->enum('kelas_kata', [
                'n', 'v', 'adj', 'adv', 'pron', 'num', 'part', 'prop', 'phrase'
            ])->nullable();

            // === PENANDA SOSIAL ===
            $table->boolean('kategori_kasar')->default(false);
            $table->enum('tingkat_formal', [
                'formal', 'informal', 'kasar'
            ])->default('informal');

            // === METADATA ===
            $table->enum('tipe_walikan', [
                'Total Segment Reversal',
                'Transposition',
                'Sequence Exchange',
                'Permutation',
                'Lainnya'
            ])->default('Total Segment Reversal');

            $table->text('catatan')->nullable();

            // === WAKTU ===
            $table->timestamps();
            $table->softDeletes();

            // === INDEX UNTUK PENCARIAN CEPAT ===
            $table->index(['bahasa_asal', 'kelas_kata']);
            $table->index('kategori_kasar');

            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $table->fullText(['kata_walikan', 'kata_asli', 'arti']);
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kosakata_walikan');
    }
};
