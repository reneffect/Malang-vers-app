<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translation_histories', function (Blueprint $table) {
            $table->bigIncrements('id_translation');
            $table->unsignedBigInteger('id_users');
            $table->enum('source_language', ['id', 'jv', 'en'])->default('id');
            $table->enum('target_language', ['id', 'jv', 'en'])->default('jv');
            $table->text('input_text');
            $table->text('translated_text')->nullable();
            $table->timestamps();

            $table->foreign('id_users')->references('id_users')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translation_histories');
    }
};