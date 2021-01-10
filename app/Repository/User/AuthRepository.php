<?php


namespace App\Repository\User;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthRepository implements AuthRepositoryInterface
{
    private $user;

    /**
     * AuthRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function authUser(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $token = Str::random(64);
            $request->user()->forceFill([
                'api_token' => $token
            ])->save();
            return ['token' => $token];
        } else {
            return response()->json('Invalid Credentiales', 404);
        }

    }

    public function logOut()
    {
        $user = Auth::user();
        $dell = $this->user->where('api_token', $user->api_token)->first();
        $dell->update(['api_token'=>null]);

        return redirect()->back();
    }

}
