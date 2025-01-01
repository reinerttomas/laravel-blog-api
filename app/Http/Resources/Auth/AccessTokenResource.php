<?php

declare(strict_types=1);

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Data\Auth\AccessTokenData
 */
final class AccessTokenResource extends JsonResource
{
    public static $wrap;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'accessToken' => $this->accessToken,
            'expiresAt' => $this->expiresAt,
        ];
    }
}
