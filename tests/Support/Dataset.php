<?php

declare(strict_types=1);

namespace Tests\Support;

use Illuminate\Database\Eloquent\Model;

final readonly class Dataset
{
    /**
     * @template TModel of Model
     *
     * @param TModel|null $model
     * @param array<string, mixed> $data
     */
    public function __construct(
        public ?Model $model = null,
        public array $data = [],
    ) {}
}
