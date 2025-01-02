<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Models\Post;
use App\Payloads\PostPayload;

final readonly class UpdatePostAction
{
    public function execute(Post $post, PostPayload $payload): void
    {
        $post->update($payload->toArray());
    }
}
