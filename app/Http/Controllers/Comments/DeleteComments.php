<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Repositories\Comments\CommentRepositoryInterface;
use Illuminate\Http\Request;

class DeleteComments extends Controller
{
    public function __construct(protected CommentRepositoryInterface $commentRepository)
    {
    }

    public function deleteComment($id)
    {
        try {
            $this->authorize('deleteComment', Comment::find($id));
            $this->commentRepository->delete($id);
            return response()->json([
                'message' => 'oke',
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
