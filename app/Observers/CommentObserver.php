<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Comment;
use App\Support\Facades\Auth;

final readonly class CommentObserver
{
    /**
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function creating(Comment $comment): void
    {
        $comment->user_id = Auth::userOrFail()->id;
    }
}
