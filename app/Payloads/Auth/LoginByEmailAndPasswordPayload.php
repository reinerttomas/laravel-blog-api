<?php

declare(strict_types=1);

namespace App\Payloads\Auth;

use Spatie\LaravelData\Data;

final class LoginByEmailAndPasswordPayload extends Data
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}
}
