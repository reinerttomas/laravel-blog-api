<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Models\Post;

final readonly class DeletePostAction
{
    public function execute(Post $post): void
    {
        $post->delete();
    }
}
