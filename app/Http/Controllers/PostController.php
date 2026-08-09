<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $posts = Post::query()
            ->with('user')
            ->withCount('comments')
            ->paginate(15);

        return PostResource::collection($posts);
    }

    public function show(Post $post): PostResource
    {
        $post->load([
            'user',
            'comments',
            'tags',
        ]);

        return new PostResource($post);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $post = Post::create(
            array_merge($validated, [
                'user_id' => Auth::id(),
            ])
        );

        return response()->json($post, 201);
    }

    public function update(
        UpdatePostRequest $request,
        Post $post
    ): JsonResponse {
        $validated = $request->validated();

        $post->update($validated);

        return response()->json($post);
    }
}