<?php

namespace App\Http\Controllers;

use App\Repository\Comment\RepositoryComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private $commentRepository;

    /**
     * CommentController constructor.
     * @param RepositoryComment $commentRepository
     */
    public function __construct(RepositoryComment $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function commentProject(Request $request, int $id)
    {
        $comment = $this->commentRepository->createCommentProject($request, $id);
        return response()->json($comment, 200);
    }

    public function commentTask(Request $request, int $id)
    {
        $comment = $this->commentRepository->createCommentTask($request, $id);
        return response()->json($comment, 200);
    }

    public function updateComment(Request $request, int $id)
    {
        $comment = $this->commentRepository->updateComment($request, $id);
        return response()->json($comment, 202);
    }

    public function updateCommentProject(Request $request, int $id)
    {
        $comment = $this->commentRepository->updateCommentProject($request,$id);
        return response()->json($comment, 202);
    }


}
