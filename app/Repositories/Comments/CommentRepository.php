<?php
namespace App\Repositories\Comments;

use App\Models\Comment;
use App\Repositories\BaseRepository;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function getModel()
    {
        return Comment::class;
    }

    public function getAllComments($id)
    {
        $comments = $this->getModel()::where('badminton_court_id', $id)
                                    ->whereNull('id_parent')
                                    ->with('childComments')
                                    ->get();
        return $comments;
    }
}
