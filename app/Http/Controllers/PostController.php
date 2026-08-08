<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function store(StorePostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $post = Post::create(
            array_merge($validated, [
                'user_id' => auth()->id(),
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