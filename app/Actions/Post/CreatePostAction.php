<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Models\Post;
use App\Payloads\PostPayload;

final readonly class CreatePostAction
{
    public function execute(PostPayload $payload): Post
    {
        return Post::create($payload->toArray());
    }
}
