<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('has comments', function (): void {
    // Arrange
    actingAs(User::factory()->create());

    $post = Post::factory()->hasComments(3)->create();

    // Act & Assert
    expect($post->comments)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Comment::class);
});
