<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalikanTranslationTest extends TestCase
{
    use RefreshDatabase;

    public function test_translation_endpoint_converts_indonesian_to_walikan(): void
    {
        $response = $this->postJson(route('translate'), [
            'text' => 'Halo',
            'direction' => 'id_to_walikan',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('translated', 'Olah')
            ->assertJsonPath('remaining', 9);

        $this->assertDatabaseHas('translation_histories', [
            'original_text' => 'Halo',
            'translated_text' => 'Olah',
            'direction' => 'id_to_walikan',
        ]);
    }

    public function test_translation_endpoint_converts_walikan_to_indonesian(): void
    {
        $response = $this->postJson(route('translate'), [
            'text' => 'Olah',
            'direction' => 'walikan_to_id',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('translated', 'Halo')
            ->assertJsonPath('remaining', 9);

        $this->assertDatabaseHas('translation_histories', [
            'original_text' => 'Olah',
            'translated_text' => 'Halo',
            'direction' => 'walikan_to_id',
        ]);
    }
}
