<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function view(User $user, Post $post): bool
    {
        if ($post->status === 'published') {
            return true;
        }

        return $post->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Post $post): bool
    {
        return $post->user_id === $user->id;
    }

    public function delete(User $user, Post $post): bool
    {
        return $post->user_id === $user->id;
    }
}