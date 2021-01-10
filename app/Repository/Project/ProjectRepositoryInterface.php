<?php


namespace App\Repository\Project;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
//use Ramsey\Collection\Collection;
use Illuminate\Database\Eloquent\Collection;
interface ProjectRepositoryInterface
{
    /*
     *  /*
     *
     * @param int $id, Request $request
     * @return Model|null
     */

    public function createProject(Request $request): Model;

    public function updateProject(Request $request, int $id): Model;

    public function findProject(Request $request): Collection;

    public function deleteProject(int $id): bool;


}
