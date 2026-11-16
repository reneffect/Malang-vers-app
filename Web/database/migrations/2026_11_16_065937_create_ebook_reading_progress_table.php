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
        Schema::create('ebooks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->string('author', 150)->nullable();
            $table->string('cover_path', 255)->nullable();
            $table->string('preview_path', 255)->nullable();
            $table->string('file_path', 255);
            $table->integer('page_count')->nullable();
            $table->decimal('price', 12, 2)->default(0)->comment('Price 0 means free; access still Member-only');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebook_reading_progress');
    }
};
