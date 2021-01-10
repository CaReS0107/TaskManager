<?php

namespace App\Http\Controllers;

use App\Repository\User\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authRepository;

    /**
     * AuthController constructor.
     * @param AuthRepository $authRepository
     */
    public function __construct(AuthRepository  $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function authUser(Request $request)
    {

        $user = $this->authRepository->authUser($request);
        return response()->json($user);

    }
    public function logOut()
    {
        $this->authRepository->logOut();
        return response()->json('Succes', 200);
    }

}
