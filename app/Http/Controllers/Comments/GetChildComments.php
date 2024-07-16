<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use App\Repositories\Comments\CommentRepositoryInterface;
use Illuminate\Http\Request;

class GetChildComments extends Controller
{
    public function __construct(protected CommentRepositoryInterface $commentRepository)
    {
    }

    public function getChildComments($id, $idBadmintonCourt)
    {
        try {
            $childComments = $this->commentRepository->getChildComments($id, $idBadmintonCourt);
            return response()->json([
                'message' => 'oke',
                'childComments' => $childComments,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
            ]);
        }
    }
}
