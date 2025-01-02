<?php

declare(strict_types=1);

namespace Tests\Structures\Api;

final readonly class AccessTokenApiStructure
{
    /**
     * @return list<string>
     */
    public static function resource(): array
    {
        return [
            'accessToken',
            'expiresAt',
        ];
    }
}
