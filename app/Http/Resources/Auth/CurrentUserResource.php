<?php

declare(strict_types=1);

namespace App\Http\Resources\Auth;

use App\Http\Resources\Shared\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User
 */
final class CurrentUserResource extends JsonResource
{
    public static $wrap;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => UserResource::make($this->resource),
        ];
    }
}
