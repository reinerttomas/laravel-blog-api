<?php

declare(strict_types=1);

use App\Models\User;
use Tests\Structures\Api\AccessTokenApiStructure;

use function Pest\Laravel\postJson;

it('can login by email and password', function (): void {
    // Arrange
    $user = User::factory()->create();

    $data = [
        'email' => $user->email,
        'password' => 'password',
    ];

    // Act & Assert
    postJson('api/auth/login', $data)
        ->assertStatus(201)
        ->assertJsonStructure(AccessTokenApiStructure::resource());
});

it('returns 422 if invalid credentials', function (array $data): void {
    // Arrange
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    // Act & Assert
    postJson('api/auth/login', $data)
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'email' => [
                'The provided credentials are incorrect.',
            ],
        ]);
})->with([
    fn (): array => [
        'email' => 'wrong-email@example.com',
        'password' => 'password',
    ],
    fn (): array => [
        'email' => 'test@example.com',
        'password' => 'wrong-password',
    ],
]);
