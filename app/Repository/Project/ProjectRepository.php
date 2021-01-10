<?php


namespace App\Repository\Project;


use App\Models\Comment;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//use Ramsey\Collection\Collection;

use Illuminate\Database\Eloquent\Collection;

class ProjectRepository implements ProjectRepositoryInterface
{
    /*
     * @var project
     */
    private $project;
    private $user;
    private $comment;


    /**
     * ProjectRepository constructor.
     * @param Project $project
     * @param User $user
     * @param Comment $comment ;
     */
    public function __construct(
        Project $project,
        User $user,
        Comment $comment
    )
    {
        $this->project = $project;
        $this->user = $user;
        $this->comment = $comment;
    }


    public function createProject(Request $request): Model
    {
        $user = Auth::user();
        $project = $this->project->create([
            'project_name' => $request->get('project_name'),
            'project_desc' => $request->get('project_desc'),
            'status' => $request->get('status'),
            'user_id' => $user->id
        ]);

        $project->details = [
            'param' => 'project_name, project_desc, status,',
            'method' => 'Post'
        ];

        return $project;
    }

    public function updateProject(Request $request, int $id): Model
    {
        $project = $this->project->findorFail($id);
        $project->project_name = $request->get('project_name');
        $project->project_desc = $request->get('project_desc');
        $project->status = $request->get('status');

        $project->save();

        $project->details = [
            'params' => 'project_name, project_desc, status',
            'method' => 'Post'
        ];

        return $project;
    }

    public function findProject(Request $request): Collection
    {
        $name = $request->get('project_name');
        $project = $this->project->where('project_name', 'LIKE', "%$name%")->get();

        if ($project->isEmpty()) {
            return response()->json(['status' => 'Missing Project'], 404);
        }

        $project->details = [
            'param' => 'project_name',
            'method' => 'get'
        ];

        return $project;
    }

    public function deleteProject(int $id)
    {
        $project = $this->project->find($id);
        $comment = $this->comment->where('commentable_id', $project->id);
        $comment->delete();
        $project->delete();

        return response()->json(202);
    }


}

