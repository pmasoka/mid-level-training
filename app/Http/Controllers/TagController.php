<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Return all tags with the number of posts using each tag.
     */
    public function index()
    {
        $tags = Tag::withCount('posts')->get();

        return response()->json($tags);
    }

    /**
     * Attach tags to a post with the given order.
     */
    public function attachToPost(Request $request, Post $post)
    {
        $validated = $request->validate([
            'tag_ids' => ['required', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
            'order' => ['required', 'integer'],
        ]);

        $attachData = [];

        foreach ($validated['tag_ids'] as $tagId) {
            $attachData[$tagId] = [
                'order' => $validated['order'],
            ];
        }

        $post->tags()->attach($attachData);

        return response()->json([
            'message' => 'Tags attached successfully.',
            'tags' => $post->tags()->get(),
        ]);
    }

    /**
     * Replace all existing tags on a post.
     */
    public function syncPost(Request $request, Post $post)
    {
        $validated = $request->validate([
            'tag_ids' => ['required', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
            'order' => ['sometimes', 'integer'],
        ]);

        $order = $validated['order'] ?? 0;

        $syncData = [];

        foreach ($validated['tag_ids'] as $tagId) {
            $syncData[$tagId] = [
                'order' => $order,
            ];
        }

        $post->tags()->sync($syncData);

        return response()->json([
            'message' => 'Post tags synced successfully.',
            'tags' => $post->tags()->get(),
        ]);
    }
}