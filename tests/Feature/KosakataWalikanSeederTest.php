<?php

namespace Tests\Feature;

use Database\Seeders\KosakataWalikanSeeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class KosakataWalikanSeederTest extends TestCase
{
    public function test_seeder_creates_walikan_words_with_the_expected_columns(): void
    {
        Schema::create('kosakata_walikan', function (Blueprint $table): void {
            $table->id();
            $table->string('kata_walikan')->unique();
            $table->string('kata_asli');
            $table->string('arti');
            $table->string('bahasa_asal')->default('Jawa');
            $table->string('kelas_kata')->nullable();
            $table->boolean('kategori_kasar')->default(false);
            $table->string('tingkat_formal')->default('informal');
            $table->string('tipe_walikan')->default('Total Segment Reversal');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $this->seed(KosakataWalikanSeeder::class);

        $this->assertDatabaseHas('kosakata_walikan', [
            'kata_walikan' => 'nakam',
            'kata_asli' => 'makan',
            'arti' => 'makan',
        ]);
    }
}
