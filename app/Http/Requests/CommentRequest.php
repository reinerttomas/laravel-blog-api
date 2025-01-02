<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Concerns\Requests\HasAnyMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class CommentRequest extends FormRequest
{
    use HasAnyMethod;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'content' => [
                Rule::requiredIf($this->isPostOrPutMethod()),
                'string',
                'max:255',
            ],
        ];
    }
}
