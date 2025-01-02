<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Post\CreateCommentOfPostAction;
use App\Actions\Post\DeleteCommentOfPostAction;
use App\Actions\Post\UpdateCommentOfPostAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Payloads\CommentPayload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @tags Post Comments
 */
final class CommentsOfPostController extends Controller
{
    /**
     * List comments.
     *
     * @response AnonymousResourceCollection<LengthAwarePaginator<CommentResource>>
     */
    public function index(
        Post $post,
        Request $request,
    ): AnonymousResourceCollection {
        $comments = $post->comments()
            ->with('user')
            ->paginate(
                perPage: $request->integer('perPage', 10),
                page: $request->integer('page', 1)
            );

        return CommentResource::collection($comments);
    }

    /**
     * Show comment.
     */
    public function show(Post $post, Comment $comment): CommentResource
    {
        return CommentResource::make($comment->load('user'));
    }

    /**
     * Create comment.
     */
    public function store(
        Post $post,
        CommentRequest $request,
        CreateCommentOfPostAction $createCommentOfPostAction,
    ): JsonResponse {
        $comment = $createCommentOfPostAction->execute(
            $post,
            CommentPayload::from($request->validated()),
        );

        return CommentResource::make($comment->load('user'))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Update comment.
     */
    public function update(
        Post $post,
        Comment $comment,
        CommentRequest $request,
        UpdateCommentOfPostAction $updateCommentOfPostAction,
    ): CommentResource {
        $updateCommentOfPostAction->execute(
            $post,
            $comment,
            CommentPayload::from($request->validated()),
        );

        return CommentResource::make($comment->load('user'));
    }

    /**
     * Delete comment.
     */
    public function destroy(
        Post $post,
        Comment $comment,
        DeleteCommentOfPostAction $deleteCommentOfPostAction,
    ): JsonResponse {
        $deleteCommentOfPostAction->execute($post, $comment);

        return $this->responseNoContent();
    }
}
