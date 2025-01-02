<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Models\Comment;
use App\Models\Post;

final readonly class DeleteCommentOfPostAction
{
    public function execute(Post $post, Comment $comment): void
    {
        $comment->delete();
    }
}
