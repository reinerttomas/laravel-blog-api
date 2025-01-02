<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('has post', function (): void {
    // Arrange
    actingAs(User::factory()->create());

    $comment = Comment::factory()->for(Post::factory())->create();

    // Act & Assert
    expect($comment->post)->toBeInstanceOf(Post::class);
});
