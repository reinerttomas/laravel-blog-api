<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Tests\Structures\Api\CommentApiStructure;
use Tests\Structures\Api\PaginatedApiStructure;
use Tests\Support\Dataset;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\patchJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

it('returns list of comments from post', function (): void {
    // Arrange
    actingAs(User::factory()->create());

    $post = Post::factory()
        ->has(Comment::factory()->count(10))
        ->create();

    // Act & Assert
    getJson('api/posts/' . $post->id . '/comments')
        ->assertStatus(200)
        ->assertJsonCount(10, 'data')
        ->assertJsonStructure(PaginatedApiStructure::of(
            CommentApiStructure::collection()
        ));
});

it('returns a comment', function (): void {
    // Arrange
    actingAs(User::factory()->create());

    $post = Post::factory()->create();
    $comment = Comment::factory()->for($post)->create();

    // Act & Assert
    getJson('api/posts/' . $post->id . '/comments/' . $comment->id)
        ->assertStatus(200)
        ->assertJsonStructure(CommentApiStructure::resource());
});

it('can create a comment', function (Dataset $dataset): void {
    // Arrange
    $user = User::factory()->create();

    actingAs($user);

    $post = Post::factory()->create();

    // Act & // Assert
    $response = postJson('api/posts/' . $post->id . '/comments', $dataset->data)
        ->assertStatus(201)
        ->assertJsonStructure(CommentApiStructure::resource());

    expect($response->json('user'))
        ->id->toBe($user->id);
})->with([
    fn (): Dataset => new Dataset(data: [
        'content' => fake()->text(255),
    ]),
]);

it('can update a comment', function (Dataset $dataset): void {
    // Arrange
    $user = User::factory()->create();

    actingAs($user);

    $post = Post::factory()->create();
    $comment = Comment::factory()->for($post)->create();

    // Act & Assert
    putJson('api/posts/' . $post->id . '/comments/' . $comment->id, $dataset->data)
        ->assertStatus(200)
        ->assertJsonStructure(CommentApiStructure::resource());
})->with([
    fn (): Dataset => new Dataset(data: [
        'content' => fake()->text(255),
    ]),
]);

it('can partial update a comment', function (Dataset $dataset): void {
    // Arrange
    $user = User::factory()->create();

    actingAs($user);

    $post = Post::factory()->create();
    $comment = Comment::factory()->for($post)->create();

    // Act & Assert
    patchJson('api/posts/' . $post->id . '/comments/' . $comment->id, $dataset->data)
        ->assertStatus(200)
        ->assertJsonStructure(CommentApiStructure::resource());
})->with([
    fn (): Dataset => new Dataset(data: [
        'content' => fake()->text(255),
    ]),
]);

it('can delete a comment', function (): void {
    // Arrange
    $user = User::factory()->create();

    actingAs($user);

    $post = Post::factory()->create();
    $comment = Comment::factory()->for($post)->create();

    // Act & Assert
    deleteJson('api/posts/' . $post->id . '/comments/' . $comment->id)
        ->assertStatus(204);
});
