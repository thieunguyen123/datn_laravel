<?php
namespace App\Repositories\Comments;

use App\Repositories\RepositoryInterface;

interface CommentRepositoryInterface extends RepositoryInterface
{
    public function getModel();
    public function getAllComments($id);
}
