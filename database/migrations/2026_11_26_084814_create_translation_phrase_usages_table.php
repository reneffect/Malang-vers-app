<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('translation_phrase_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('translation_history_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->text('indonesian_word');
            $table->text('walikan_word');
            $table->timestamps();
        });

        $this->backfillHistoricalUsages();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translation_phrase_usages');
    }

    private function backfillHistoricalUsages(): void
    {
        DB::table('translation_histories')
            ->select(['id', 'original_text', 'translated_text', 'direction', 'created_at', 'updated_at'])
            ->orderBy('id')
            ->chunkById(100, function ($histories): void {
                $usages = [];

                foreach ($histories as $history) {
                    $originalWords = $this->words($history->original_text);
                    $translatedWords = $this->words($history->translated_text);

                    if ($originalWords === [] && $translatedWords === []) {
                        continue;
                    }

                    if (count($originalWords) !== count($translatedWords)) {
                        throw new LogicException(
                            "Translation history {$history->id} has mismatched word counts."
                        );
                    }

                    foreach ($originalWords as $index => $originalWord) {
                        $isIndonesianFirst = $history->direction === 'id_to_walikan';
                        $usages[] = [
                            'translation_history_id' => $history->id,
                            'indonesian_word' => $isIndonesianFirst ? $originalWord : $translatedWords[$index],
                            'walikan_word' => $isIndonesianFirst ? $translatedWords[$index] : $originalWord,
                            'created_at' => $history->created_at ?? now(),
                            'updated_at' => $history->updated_at ?? now(),
                        ];
                    }
                }

                foreach (array_chunk($usages, 100) as $usageBatch) {
                    DB::table('translation_phrase_usages')->insert($usageBatch);
                }
            });
    }

    /**
     * @return list<string>
     */
    private function words(string $text): array
    {
        if (preg_match_all('/[\p{L}\p{N}]+/u', mb_strtolower($text), $matches) === false) {
            throw new RuntimeException('Unable to tokenize a translation history record.');
        }

        return $matches[0];
    }
};
