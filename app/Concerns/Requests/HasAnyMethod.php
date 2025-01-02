<?php

declare(strict_types=1);

namespace App\Concerns\Requests;

use Closure;

/**
 * @mixin \Illuminate\Foundation\Http\FormRequest
 */
trait HasAnyMethod
{
    /**
     * @param  list<string>  $methods
     * @return Closure(): bool
     */
    protected function isAnyMethod(array $methods): Closure
    {
        return fn (): bool => array_any($methods, fn ($method): bool => $this->isMethod($method));
    }

    /**
     * @return Closure(): bool
     */
    protected function isPostOrPutMethod(): Closure
    {
        return $this->isAnyMethod(['POST', 'PUT']);
    }

    /**
     * @return Closure(): bool
     */
    protected function isPatchMethod(): Closure
    {
        return fn (): bool => $this->isMethod('PATCH');
    }
}
