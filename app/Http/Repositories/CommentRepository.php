<?php


namespace App\Http\Repositories;


use App\Entities\Comment;


class CommentRepository extends Repository
{
    protected $model;

    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function getAllWithReplies()
    {
        return Comment::parent()->with('replies')->get();
    }

}