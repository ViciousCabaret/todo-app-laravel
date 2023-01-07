<?php

namespace App\Http\Controllers;

use App\Http\Helper\RandomStringGenerator;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{

    public function index(AdminRequest $request)
    {
        return $this->returnDefaultSingleDataResponse(
            User::all()
        );
    }

    public function show(AdminRequest $request, User $user)
    {
        return $this->returnDefaultDataResponse($user);
    }

    public function store(CreateUserRequest $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'invitation_link' => $request->get('invitation_link') ?? RandomStringGenerator::generate(20),
            'roles' => $request->get('roles'),
        ]);

        return $this->returnDefaultSingleDataResponse($user, 201);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'roles' => $request->get('roles'),
        ]);

        return $this->returnDefaultSingleDataResponse($user, 201);
    }

    public function destroy(AdminRequest $request, User $user)
    {
        $user->delete();
        return $this->returnDefaultResponse();
    }
}
