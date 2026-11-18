<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translation_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->enum('source_language', ['id', 'jv', 'en']); // ⚠️ kode_bahasa
            $table->enum('target_language', ['id', 'jv', 'en']); // ⚠️
            $table->text('input_text');
            $table->text('translated_text');
            $table->integer('word_count')->default(0);
            $table->integer('credit_used')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translation_histories');
    }
};
