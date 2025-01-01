<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Shared\UserResource;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;

/**
 * @tags Auth
 */
final class CurrentUserController extends Controller
{
    /**
     * User.
     *
     * Get the current user.
     *
     * @operationId getCurrentUser
     *
     * @unauthenticated
     */
    public function __invoke(#[CurrentUser] User $user): UserResource
    {
        return new UserResource($user);
    }
}
