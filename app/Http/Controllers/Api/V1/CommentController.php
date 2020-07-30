<?php

namespace App\Http\Controllers\Api\V1;


use App\Entities\Comment;
use App\Http\Repositories\CommentRepository;
use App\Http\Requests\CommentStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CommentController extends BaseApiController
{

    protected $repository;

    /**
     * CommentController constructor.
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->repository = $commentRepository;
    }


    public function index()
    {
       return $this->repository->getAllWithReplies();
    }

    /**
     * @param CommentStoreRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function store(CommentStoreRequest $request)
    {

        try {

            $comment = $this->repository->store($request->all());

        } catch (\Exception $e) {

            return $e->getMessage();
        }

        return response()->json($comment, Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function update(Request $request, Comment $comment)
    {
        try {

            $comment = $this->repository->update($request->all(), $comment->id);

        } catch (\Exception $e ) {

            return $e->getMessage();
        }

        return response()->json($comment, Response::HTTP_OK);
    }

    /**
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function destroy(Comment $comment)
    {
        try {

            $comment = $this->repository->delete($comment->id);

        } catch (\Exception $e) {

            return $e->getMessage();

        }

        return response()->json($comment, Response::HTTP_OK);
    }
}
