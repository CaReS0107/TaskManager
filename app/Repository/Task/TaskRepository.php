<?php


namespace App\Repository\Task;



use App\Models\Comment;
use App\Models\Priority;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskRepository implements TaskRepositoryInterface
{
    /*
     * @var Task
     */
    private $task;
    private $project;
    private $priority;
    private $comment;


    /**
     * TaskRepository constructor.
     *
     * @param Task $task
     * @param Project $project
     * @param Priority $priority
     * @param Comment $comment
     */

    public function __construct(Task $task, Project $project, Priority $priority, Comment $comment)
    {
        $this->task = $task;
        $this->project = $project;
        $this->priority = $priority;
        $this->comment = $comment;

    }

    public function findTask(Request $request)
    {
        $name = $request->get('task_name');
        $task = $this->task->where('task_name', 'LIKE', "%$name%")->get();

        if ($task->isEmpty()) {
            return response()->json(['status' => 'Missing task'], 404);
        }

        $task->details = [
            'params' => 'task_name',
            'method' => 'post',
            'task' => $task
        ];
        return $task->details;
    }

    public function createTask(Request $request): Model
    {
        $user = Auth::user();
        $task = $this->task->create([
            'task_name' => $request->get('task_name'),
            'task_desc' => $request->get('task_desc'),
            'status' => $request->get('status'),
            'deadline' => $request->get('deadline'),
            'task_created_at' => $request->get('task_created_at'),
            'task_started_at' => $request->get('task_started_at'),
            'user_id' => $user->id
        ]);
        $task->details = [
            'param' => 'task_name, task_desc, status, deadline, task_created_at, task_started_at',
            'method' => 'post',

        ];

//        dd($task->toArray());

        return $task;

    }

    public function startTask(int $id): ?Model
    {
        $task = $this->task->findOrFail($id);

        $task->task_started_at = Carbon::now();
        $task->save();
        return $task;

    }

    public function destroyTask(int $id): Model
    {
        $task = $this->task->find($id);
        if (!$task) {
           abort('missing task', 404);
        }
        $comment = $this->comment->where('commentable_id', $task->id);
        $comment->delete();
        $task->delete();
        return $task;
    }

    public function updateTask(Request $request, int $id): Model
    {
        $task = $this->task->findOrFail($id);
        $task->task_name = $request->get('task_name');
        $task->task_desc = $request->get('task_desc');
        $task->status = $request->get('status');
        $task->deadline = $request->get('deadline');
        $task->task_created_at = $request->get('task_created_at');
        $task->task_started_at = $request->get('task_started_at');

        $task->save();
        $task->details = [
            'param' => 'task_name, task_desc, status, deadline, task_created_at, task_started_at',
            'method' => 'post',

        ];
        return $task;

    }

    public function attachTask(Request $request, int $id): Model
    {

            $request->validate([
                "project_id"=>"required"
            ]);
        $task = $this->task->find($id);
        $projects = $request->get('project_id');
        $task->projects()->attach($projects);

        $task->details = [
            'param' => 'project_id',
            'method' => 'get',
        ];

        return $task;

    }

    public function attachPriotiy(Request $request, int $id): Model
    {
        dd('here');
        $task = $this->task->find($id);

        $priority = $request->get('priority_name');

        $task->details = [
            'Param' => 'priority_name',
            'Method' => 'post'
        ];
        $task->priorities()->attach($priority);
        return $task;
    }

    public function getPriorityTask(Request $request)
    {
        $tasks = $this->task;
        $priority = $request->get('priority_name');
        $user = Auth::user();

        $result = $tasks->query()
            ->whereHas('priorities', function (Builder $query) use ($priority, $user) {
                $query->where('user_id', $user->id);
                $query->whereIn('priority_id', [$priority]);

            })->get();

        $result->details = [
            'Param' => 'priority_name',
            'Method' => 'get',
            'User' => $user,
            'Tasks' => $result
        ];
        
        return $result->details;
    }

    public function getProjectActiveTask(Request $request)
    {
        $project = $this->project;
        $taskActive = $request->get('status');
        $user = Auth::user();

        $result = $project->query()
            ->where('user_id', $user->id)
            ->whereHas('tasks', function (Builder $query) use ($taskActive) {
                $query->where('status', [$taskActive]);

            })->get();

        $result->details = [
            'Param' => 'status',
            'Method' => 'get',
            'User' => $user,
            'Project' => $result
        ];
        return $result->details;
    }



}
