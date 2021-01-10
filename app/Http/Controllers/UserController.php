<?php

namespace App\Http\Controllers;

use App\Repository\User\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     */

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function findByEmail(Request $request)
    {
        $user = $this->userRepository->findByEmail($request);


        return response()->json([
            'param' => 'email',
            'method' => 'Get',
            'user' => $user->load('projects.tasks')
        ]);


        //return response()->json( $user->load('projects.tasks.comments', $user->feed), 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeUser(Request $request)
    {
        $user = $this->userRepository->createUser($request);

        return response()->json($user, 201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request, $id)
    {

        $user = $this->userRepository->updateUser($request, $id);

        return response()->json($user, 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUser($id)
    {

        $this->userRepository->deleteUser($id);

        return response()->json('User Deleted', 202);
    }

    public function getUserProject(Request $request)
    {
        $user = $this->userRepository->findUserProject($request);

        return response()->json($user, 200);
    }

    public function attachToProject(Request $request)
    {
        $user = $this->userRepository->attachUserToProject($request);
        return response()->json($user->load('projects'), 200);
    }
}
