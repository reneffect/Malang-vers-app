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
        if (Schema::hasTable('ebook_reading_progress')) {
            if (! Schema::hasColumns('ebook_reading_progress', [
                'id',
                'user_id',
                'ebook_id',
                'last_page',
                'progress_percentage',
                'last_read_at',
                'created_at',
                'updated_at',
            ])) {
                throw new RuntimeException('The existing ebook_reading_progress table does not match the expected schema.');
            }

            if (! Schema::hasTable('buku_digital')) {
                throw new RuntimeException('The buku_digital table is required to link existing ebook reading progress.');
            }

            if (! Schema::hasForeignKey('ebook_reading_progress', 'ebook_id')) {
                Schema::table('ebook_reading_progress', function (Blueprint $table) {
                    $table->foreign('ebook_id')->references('id')->on('buku_digital');
                });
            }

            return;
        }

        Schema::create('ebook_reading_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('ebook_id')->constrained('buku_digital');
            $table->integer('last_page')->default(1);
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->dateTime('last_read_at')->nullable();
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
