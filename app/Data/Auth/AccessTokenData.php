<?php

declare(strict_types=1);

namespace App\Data\Auth;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

final class AccessTokenData extends Data
{
    public function __construct(
        public readonly string $accessToken,
        public readonly CarbonImmutable $expiresAt,
    ) {}
}
