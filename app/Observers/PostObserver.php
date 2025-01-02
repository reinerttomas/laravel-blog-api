<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Post;
use App\Support\Facades\Auth;

final readonly class PostObserver
{
    /**
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function creating(Post $post): void
    {
        $post->user_id = Auth::userOrFail()->id;
    }

    public function updating(Post $post): void
    {
        if ($post->isDirty('status')) {
            $post->evaluateStatus();
        }
    }
}
