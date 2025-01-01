<?php

declare(strict_types=1);

namespace Tests\AssertableJson;

use Closure;
use Illuminate\Testing\Fluent\AssertableJson;

final readonly class AccessTokenAssertableJson
{
    /**
     * @return Closure(AssertableJson $json): AssertableJson
     */
    public static function resource(): Closure
    {
        return fn (AssertableJson $json): AssertableJson => $json
            ->hasAll([
                'accessToken',
                'expiresAt',
            ]);
    }
}
