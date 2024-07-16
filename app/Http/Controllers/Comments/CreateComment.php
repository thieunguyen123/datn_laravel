<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\CreateComments;
use App\Repositories\Comments\CommentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CreateComment extends Controller
{
    public function __construct(protected CommentRepositoryInterface $commentRepository)
    {
    }

    public function createComment($idBadmintonCourt, createComments $request)
    {
        try {
            $id = Auth::id();
            $parentId = $request->has('id_parent') ? $request->id_parent : null;
            $this->commentRepository->create([
                'id_parent' => $parentId,
                'content' => $request->content,
                'user_id' => $id,
                'badminton_court_id' => $idBadmintonCourt,
            ]);
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
