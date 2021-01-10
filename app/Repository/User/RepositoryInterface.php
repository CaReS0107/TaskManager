<?php


namespace App\Repository\User;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface RepositoryInterface
{
    /*
     *
     * @param int $id, Request $request
     * @return Model|null
     */

    public function findByEmail(Request $request);

    public function createUser(Request $request): ?Model;

    public function deleteUser(int $id): ?Model;

    public function updateUser(Request $request, int $id): ?Model;

    public function findUserProject(Request $request);

    public function attachUserToProject(Request $request);


}
