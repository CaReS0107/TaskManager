<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskValidation;
use App\Repository\Task\TaskRepository;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $taskRepository;

    /**
     * TaskController constructor.
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }


    public function findTask(Request $request)
    {
        $user = $this->taskRepository->findTask($request);
        return response()->json($user, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTask(Request $request)
    {
        $task = $this->taskRepository->createTask($request);

        return response()->json($task, 200);
    }

    /**
     * Set begin to task!
     *
     */
    public function startTask(int $id)
    {
        $startTask = $this->taskRepository->startTask($id);

        return response()->json($startTask, 200);
    }

    public function updateTask(Request $request, int $id)
    {
        $task = $this->taskRepository->updateTask($request, $id);

        return response()->json($task, 202);
    }

    public function destroyTask($id)
    {
        $this->taskRepository->destroyTask($id);
        return response()->json('Succes', 200);
    }

    public function attachToProject(Request $request, int $id)
    {
        $task = $this->taskRepository->attachTask($request, $id);

        return response()->json($task->load('projects.comments'), 200);

    }

    public function attachpriority(Request $request, int $id)
    {

        $priority = $this->taskRepository->attachPriotiy($request, $id);
        return response()->json($priority);
    }

    public function taskPriority(Request $request)
    {
        $tasks = $this->taskRepository->getPriorityTask($request);
        return response()->json($tasks, 202);
    }

    public function projectActiveTask(Request $request)
    {

        $project = $this->taskRepository->getProjectActiveTask($request);
        return response()->json($project, 202);
    }


}
