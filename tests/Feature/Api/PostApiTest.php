<?php

declare(strict_types=1);

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\User;
use Tests\Structures\Api\PaginatedApiStructure;
use Tests\Structures\Api\PostApiStructure;
use Tests\Support\Dataset;

use function Pest\Faker\fake;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\patchJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

it('returns paginated list of posts', function (): void {
    // Arrange
    actingAs(User::factory()->create());

    Post::factory()->count(10)->create();

    // Act & Assert
    getJson('api/posts')
        ->assertStatus(200)
        ->assertJsonCount(10, 'data')
        ->assertJsonStructure(PaginatedApiStructure::of(
            PostApiStructure::collection()
        ));
});

it('returns a post', function (): void {
    // Arrange
    actingAs(User::factory()->create());

    $post = Post::factory()->create();

    // Assert & Act
    getJson('api/posts/' . $post->id)
        ->assertStatus(200)
        ->assertJsonStructure(PostApiStructure::resource());
});

it('can create a post', function (Dataset $dataset): void {
    // Arrange
    $user = User::factory()->create();

    actingAs($user);

    // Assert & Act
    $response = postJson('api/posts', $dataset->data)
        ->assertStatus(201)
        ->assertJsonStructure(PostApiStructure::resource());

    expect($response->json('user'))
        ->id->toBe($user->id);
})->with([
    fn (): Dataset => new Dataset(data: [
        'title' => fake()->text(255),
        'content' => fake()->text(255),
    ]),
]);

it('can update a post', function (Dataset $dataset): void {
    // Arrange
    actingAs(User::factory()->create());

    $post = Post::factory()->create();

    // Assert & Act
    putJson('api/posts/' . $post->id, $dataset->data)
        ->assertStatus(200)
        ->assertJsonStructure(PostApiStructure::resource());
})->with([
    fn (): Dataset => new Dataset(data: [
        'title' => fake()->text(255),
        'content' => fake()->text(255),
    ]),
]);

it('can publish a post', function (Dataset $dataset): void {
    // Arrange
    actingAs(User::factory()->create());

    $post = Post::factory()->create();

    // Assert & Act
    $response = patchJson('api/posts/' . $post->id, $dataset->data)
        ->assertStatus(200)
        ->assertJsonStructure(PostApiStructure::resource());

    expect($response->json())
        ->status->toBe(PostStatus::Published->value)
        ->publishedAt->not->toBeNull();
})->with([
    fn (): Dataset => new Dataset(data: [
        'status' => PostStatus::Published,
    ]),
]);

it('can archive a post', function (Dataset $dataset): void {
    // Arrange
    actingAs(User::factory()->create());

    $post = Post::factory()->create();

    // Assert & Act
    $response = patchJson('api/posts/' . $post->id, $dataset->data)
        ->assertStatus(200)
        ->assertJsonStructure(PostApiStructure::resource());

    expect($response->json())
        ->status->toBe(PostStatus::Archived->value)
        ->archivedAt->not->toBeNull();
})->with([
    fn (): Dataset => new Dataset(data: [
        'status' => PostStatus::Archived,
    ]),
]);

it('can delete a post', function (): void {
    // Arrange
    actingAs(User::factory()->create());

    $post = Post::factory()->create();

    // Act & Assert
    deleteJson('api/posts/' . $post->id)
        ->assertStatus(204);
});
