<?php

declare(strict_types=1);

namespace Tests\Structures\Api;

final readonly class UserApiStructure
{
    /**
     * @return list<string>
     */
    public static function resource(): array
    {
        return [
            'id',
            'name',
            'email',
            'createdAt',
            'updatedAt',
        ];
    }

    /**
     * @return array<string, list<string>>
     */
    public static function collection(): array
    {
        return [
            '*' => self::resource(),
        ];
    }
}
