<?php

declare(strict_types=1);

namespace App\Payloads;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

final class CommentPayload extends Data
{
    public function __construct(
        public readonly string|Optional $content,
    ) {}
}
