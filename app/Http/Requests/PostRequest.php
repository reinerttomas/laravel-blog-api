<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Concerns\Requests\HasAnyMethod;
use App\Enums\PostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class PostRequest extends FormRequest
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
            'title' => [
                Rule::requiredIf($this->isPostOrPutMethod()),
                'string',
                'max:255',
            ],
            'content' => [
                Rule::requiredIf($this->isPostOrPutMethod()),
                'string',
                'max:255',
            ],
            'status' => [
                Rule::prohibitedIf($this->isPostOrPutMethod()),
                Rule::enum(PostStatus::class),
            ],
        ];
    }
}
