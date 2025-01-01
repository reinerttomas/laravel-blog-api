<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\LoginByEmailAndPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginByEmailAndPasswordRequest;
use App\Http\Resources\Auth\AccessTokenResource;
use App\Payloads\Auth\LoginByEmailAndPasswordPayload;
use Illuminate\Http\JsonResponse;

/**
 * @tags Auth
 */
final class LoginByEmailAndPasswordController extends Controller
{
    /**
     * Login.
     *
     * @operationId loginByEmailAndPassword
     *
     * @unauthenticated
     */
    public function __invoke(
        LoginByEmailAndPasswordRequest $request,
        LoginByEmailAndPasswordAction $loginAction,
    ): JsonResponse {
        $accessToken = $loginAction->execute(
            LoginByEmailAndPasswordPayload::from($request->validated())
        );

        return AccessTokenResource::make($accessToken)
            ->response()
            ->setStatusCode(201);
    }
}
