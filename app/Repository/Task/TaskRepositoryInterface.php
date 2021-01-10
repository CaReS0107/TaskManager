<?php


namespace App\Repository\Task;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


interface TaskRepositoryInterface
{
    public function findTask(Request $request);

    public function createTask(Request $request): Model;

    public function startTask(int $id): ?Model;

    public function destroyTask(int $id): Model;

    public function updateTask(Request $request, int $id): Model;

    public function attachTask(Request $request, int $id): Model;

    public function attachPriotiy(Request $request, int $id): Model;

    public function getPriorityTask(Request $request);

    public function getProjectActiveTask(Request $request);


}
