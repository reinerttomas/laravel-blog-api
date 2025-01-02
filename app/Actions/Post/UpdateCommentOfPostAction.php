<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Models\Comment;
use App\Models\Post;
use App\Payloads\CommentPayload;

final readonly class UpdateCommentOfPostAction
{
    public function execute(Post $post, Comment $comment, CommentPayload $payload): void
    {
        $comment->update($payload->toArray());
    }
}
