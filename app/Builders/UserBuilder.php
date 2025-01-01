<?php

declare(strict_types=1);

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<\App\Models\User>
 */
final class UserBuilder extends Builder
{
    public function whereEmail(string $email): self
    {
        return $this->where('email', $email);
    }
}
