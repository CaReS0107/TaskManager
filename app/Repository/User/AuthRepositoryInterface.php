<?php


namespace App\Repository\User;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    public function authUser(Request $request);
    public function logOut();

}
