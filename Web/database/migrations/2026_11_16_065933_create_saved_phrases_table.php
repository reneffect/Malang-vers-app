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
        Schema::create('saved_phrases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('dictionary_entry_id')->nullable()->constrained('dictionary_entries');
            $table->enum('source_language', ['id', 'jv', 'en']);
            $table->enum('target_language', ['id', 'jv', 'en']);
            $table->text('original_text');
            $table->text('translated_text');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_phrases');
    }
};
