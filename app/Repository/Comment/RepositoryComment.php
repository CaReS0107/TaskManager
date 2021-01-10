<?php


namespace App\Repository\Comment;


use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RepositoryComment implements CommentInterfaceRepository
{
    private $comment;
    private $project;

    /**
     * RepositoryComment constructor.
     * @param Comment $comment
     * @param Project $project
     * @param Task $task
     */

    public function __construct(Comment $comment, Project $project, Task $task)
    {
        $this->comment = $comment;
        $this->project = $project;
        $this->task = $task;
    }


    public function createCommentProject(Request $request, int $id)
    {
        $project = $this->project->find($id);
        $user = Auth::user();



        $comment = $project->comments()->create([
            'comment' => $request->get('comment'),
            'user_id' => $user->id
        ]);
        $comment->details = [
            'param' => 'comment',
            'method' => 'post'
        ];

        return $comment;
    }

    public function createCommentTask(Request $request, int $id)
    {
        $task = $this->task->find($id);

        $user = Auth::user();

        $comment = $task->comments()->create([
            'comment' => $request->get('comment'),
            'user_id' => $user->id
        ]);
        $comment->details = [
            'param' => 'comment',
            'method' => 'post'
        ];
        return $comment;
    }

    public function updateComment(Request $request, int $id)
    {
        $task = $this->task->findOrFail($id);
        $comment = $this->comment->where('commentable_id', $task->id)->firstOrFail();
        $comment->comment = $request->get('comment');
        $comment->save();
        $comment->details = [
            'params' => 'comment',
            'method' => 'post'

        ];
        return $comment;
    }

    public function updateCommentProject(Request $request, int $id)
    {
        $project = $this->project->findOrFail($id);
        $comment = $this->comment->where('commentable_id', $project->id)->firstOrFail();
        $comment->comment = $request->get('comment');
        $comment->save();
        $comment->details = [
            'params' => 'comment',
            'method' => 'post'

        ];
        return $comment;
    }
}
