<?php

declare(strict_types=1);

use App\Models\User;
use Tests\AssertableJson\UserAssertableJson;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

it('returns current authenticated user', function (): void {
    // Arrange
    actingAs(User::factory()->create());

    // Act & Assert
    getJson('api/auth/user')
        ->assertStatus(200)
        ->assertJson(UserAssertableJson::resource());
});

it('returns 401 if not authenticated', function (): void {
    getJson('api/auth/user')
        ->assertStatus(401)
        ->assertJson([
            'message' => 'Unauthenticated.',
        ]);
});
