<?php

declare(strict_types=1);

use function Pest\Laravel\getJson;

it('returns a successful response', function (): void {
    getJson('/api/ping')
        ->assertStatus(200)
        ->assertJson(['message' => 'pong']);
});
