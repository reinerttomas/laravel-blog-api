<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Data\Auth\AccessTokenData;
use App\Models\User;
use App\Payloads\Auth\LoginByEmailAndPasswordPayload;
use App\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

final readonly class LoginByEmailAndPasswordAction
{
    public function __construct(
        private CreateAccessTokenAction $createAccessTokenAction,
    ) {}

    public function execute(LoginByEmailAndPasswordPayload $payload): AccessTokenData
    {
        $user = User::whereEmail($payload->email)->first();

        if (! $user) {
            $this->throwValidationException();
        }

        $attempt = Auth::attempt($payload->all());

        if (! $attempt) {
            $this->throwValidationException();
        }

        return $this->createAccessTokenAction->execute($user);
    }

    private function throwValidationException(): never
    {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
}
