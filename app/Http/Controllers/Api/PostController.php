<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Post\CreatePostAction;
use App\Actions\Post\DeletePostAction;
use App\Actions\Post\UpdatePostAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Payloads\PostPayload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

final class PostController extends Controller
{
    /**
     * List posts.
     *
     * @response AnonymousResourceCollection<LengthAwarePaginator<PostResource>>
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $posts = Post::with('user')
            ->paginate(
                perPage: $request->integer('perPage', 10),
                page: $request->integer('page', 1)
            );

        return PostResource::collection($posts);
    }

    /**
     * Show post.
     */
    public function show(Post $post): PostResource
    {
        return PostResource::make($post->load('user'));
    }

    /**
     * Create post.
     */
    public function store(
        PostRequest $request,
        CreatePostAction $createPostAction
    ): JsonResponse {
        $post = $createPostAction->execute(
            PostPayload::from($request->validated())
        );

        return PostResource::make($post->load('user'))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Update post.
     */
    public function update(
        Post $post,
        PostRequest $request,
        UpdatePostAction $updatePostAction
    ): PostResource {
        $updatePostAction->execute(
            $post,
            PostPayload::from($request->validated())
        );

        return PostResource::make($post->load('user'));
    }

    /**
     * Delete post.
     */
    public function destroy(
        Post $post,
        DeletePostAction $deletePostAction,
    ): JsonResponse {
        $deletePostAction->execute($post);

        return $this->responseNoContent();
    }
}
