<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\UpdateComments as UpdateCommentsRequest;
use App\Models\Comment;
use App\Repositories\Comments\CommentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UpdateComments extends Controller
{
    public function __construct(protected CommentRepositoryInterface $commentRepository)
    {
    }

    public function updateComment($id, $idBadmintonCourt, UpdateCommentsRequest $request)
    {
        try {
            $this->authorize('updateComment', Comment::find($id));
            $idUser = Auth::id();
            $parentId = $request->has('id_parent') ? $request->id_parent : null;
            $this->commentRepository->update($id,[
                'id_parent' => $parentId,
                'content' => $request->content,
                'user_id' => $idUser,
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
