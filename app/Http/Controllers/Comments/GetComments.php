<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comments;
use App\Repositories\Comments\CommentRepositoryInterface;
use Illuminate\Http\Request;

class GetComments extends Controller
{
    public function __construct(protected CommentRepositoryInterface $commentRepository)
    {
    }

    public function getAllComments($id)
    {
        try {
            $comments = $this->commentRepository->getAllComments($id);
            return response()->json([
                'message' => 'oke',
                'comments' => Comments::collection($comments),
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ],500);
        }
    }
}
