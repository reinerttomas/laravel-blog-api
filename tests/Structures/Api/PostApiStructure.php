<?php

declare(strict_types=1);

namespace Tests\Structures\Api;

final readonly class PostApiStructure
{
    /**
     * @return array<string, mixed>
     */
    public static function resource(): array
    {
        return [
            'id',
            'title',
            'content',
            'likes',
            'dislikes',
            'status',
            'publishedAt',
            'archivedAt',
            'createdAt',
            'updatedAt',
            'user' => UserApiStructure::resource(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function collection(): array
    {
        return [
            '*' => self::resource(),
        ];
    }
}
