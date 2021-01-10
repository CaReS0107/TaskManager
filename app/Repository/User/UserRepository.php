<?php


namespace App\Repository\User;


use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserRepository implements RepositoryInterface
{
    /*
     * @var User
     */
    private $user;
    private $project;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     * @param Project $project
     *
     */
    public function __construct(User $user, Project $project)
    {
        $this->user = $user;
        $this->project = $project;

    }

    //----Function find User by Email----//
    public function findByEmail(Request $request)
    {

        $user = $this->user->where('email', $request->get('email'))->get();

        return $user;

    }

    //----Function for Create User----//
    public function createUser(Request $request): ?Model
    {
        if ($request->file('images')) {
            if ($request->file('images')->isValid()) {
                $images = $request->file('images');
                $new_name = rand() . '.' . $images->extension();
                $img = $request->images->storeAs('', $new_name);
            }
        }
        $user = $this->user->create([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'images' => $img,
            'password' => Hash::make($request->get('password')),

        ]);
        $userRole = Role::where('name', 'user')->first();
        $user->roles()->attach($userRole);

        $user->details = [
            'params' => 'first_name, last_name, email, images, password',
            'method' => 'POST',
            'href' => [
                'delete' => '/api/delete/user/' . $user->id,
                'update' => '/api/update/user/' . $user->id,
                'view' => '/api/user/' . $user->id
            ],
        ];
        return $user;
    }

    //----Function for delete user by ID----//
    public function deleteUser(int $id): ?Model
    {
        $user = $this->user->find($id);

        if (!$user) {
            abort(404, ['Status' => 'User not found']);
        }

        $path = Storage::path($user->images);
        File::delete($path);
        $user->delete();

        return $user;
    }

    //----Function for update First Name, Last Name and Images----//
    public function updateUser(Request $request, $id): ?Model
    {

        $user = $this->user->find($id);
        $path = Storage::path($user->images);
        File::delete($path);

        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');

        if ($request->file('images')) {
            if ($request->file('images')->isValid()) {
                $images = $request->file('images');
                $new_name = rand() . '.' . $images->extension();
                $img = $request->images->storeAs('', $new_name);
                $user->images = $img;
            }
        }
        $user->update();
        $user->details = [
            'params' => 'first_name, last_name, images',
            'method' => 'post'
        ];
        return $user;

    }

    public function findUserProject(Request $request)
    {
        $user = Auth::user();
        $result = $user->projects->where('status', true);

        $result->details = [
            'method' => 'get',
            'projects' => $result
        ];

        return $result->details;

    }

    public function attachUserToProject(Request $request)
    {
        $user = $this->user->where('email', $request->get('email'))->firstOrFail();

        $project = $this->project->where('id', $request->get('project_name'))->firstOrFail();

        $user->projects()->attach($project);

        $user->details = [
            'method' => 'get',
            'params' => 'email, project_name'
        ];

        return $user;
    }


}
