<?php


namespace App\Repository\Comment;


use Illuminate\Http\Request;

interface CommentInterfaceRepository
{
    public function createCommentProject(Request $request, int $id);

    public function createCommentTask(Request $request, int $id);

    public function updateComment(Request $request, int $id);

    public function updateCommentProject(Request $request, int $id);


}
