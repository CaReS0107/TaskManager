<?php

namespace App\Http\Controllers;

use App\Repository\Project\ProjectRepository;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    private $projectRepository;

    /**
     * ProjectController constructor.
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function createProject(Request $request)
    {
        $project = $this->projectRepository->createProject($request);

        return response()->json($project, 200);
    }
public function updateProject(Request $request, int $id)
    {
        $project = $this->projectRepository->updateProject($request, $id);
        return response()->json($project, 202);

    }
    public function findProject(Request $request)
    {

        $project = $this->projectRepository->findProject($request);

        return response()->json($project,200);

    }
    public function deleteProject($id)
    {
        $this->projectRepository->deleteProject($id);
        return response()->json('Project was deleted',202);
    }



}
