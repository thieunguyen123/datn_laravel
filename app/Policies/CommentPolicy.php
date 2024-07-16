<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function updateComment(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }

    public function deleteComment(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }
}
