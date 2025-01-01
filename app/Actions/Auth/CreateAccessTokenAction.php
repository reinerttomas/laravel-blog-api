<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Data\Auth\AccessTokenData;
use App\Models\User;
use Carbon\CarbonImmutable;

final readonly class CreateAccessTokenAction
{
    public function execute(User $user): AccessTokenData
    {
        $expiresAt = CarbonImmutable::now()->addHours(2);

        $token = $user->createToken(
            name: 'AccessToken',
            expiresAt: $expiresAt,
        );

        $accessToken = str($token->plainTextToken)->explode('|')->last();

        return new AccessTokenData($accessToken, $expiresAt);
    }
}
