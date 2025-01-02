<?php

declare(strict_types=1);

namespace Tests\Structures\Api;

final readonly class PaginatedApiStructure
{
    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public static function of(array $data): array
    {
        return [
            'data' => $data,
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links',
                'path',
                'per_page',
                'to',
                'total',
            ],
        ];
    }
}
