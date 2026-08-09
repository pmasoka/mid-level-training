<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'status' => $this->status,
            'created_at' => $this->created_at?->toISOString(),

            'author' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                ];
            }),

            'comments_count' => $this->whenNotNull(
                $this->comments_count
            ),

            'tags' => TagResource::collection(
                $this->whenLoaded('tags')
            ),

            'comments' => CommentResource::collection(
                $this->whenLoaded('comments')
            ),
        ];
    }
}