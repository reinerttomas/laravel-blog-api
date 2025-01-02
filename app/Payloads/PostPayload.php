<?php

declare(strict_types=1);

namespace App\Payloads;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapOutputName(SnakeCaseMapper::class)]
final class PostPayload extends Data
{
    public function __construct(
        public readonly string|Optional $title,
        public readonly string|Optional $content,
        public readonly string|Optional $status,
    ) {}
}
