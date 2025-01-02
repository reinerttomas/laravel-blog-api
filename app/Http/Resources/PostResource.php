<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\Resources\Shared\UserResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Post
 */
final class PostResource extends JsonResource
{
    public static $wrap;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'likes' => $this->likes,
            'dislikes' => $this->dislikes,
            'status' => $this->status,
            'publishedAt' => $this->published_at,
            'archivedAt' => $this->archived_at,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
