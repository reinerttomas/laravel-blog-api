<?php

declare(strict_types=1);

namespace Tests\AssertableJson;

use Closure;
use Illuminate\Testing\Fluent\AssertableJson;

final readonly class UserAssertableJson
{
    /**
     * @return Closure(AssertableJson $json): AssertableJson
     */
    public static function resource(): Closure
    {
        return fn (AssertableJson $json): AssertableJson => $json
            ->whereAllType([
                'id' => 'integer',
                'name' => 'string',
                'email' => 'string',
                'createdAt' => 'string',
                'updatedAt' => 'string',
            ]);
    }
}
