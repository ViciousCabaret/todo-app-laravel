<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest\DeleteGroupRequest;
use App\Http\Requests\GroupRequest\KickUserRequest;
use App\Http\Requests\GroupRequest\LeaveGroupRequest;
use App\Http\Requests\GroupRequest\ShowGroupRequest;
use App\Http\Requests\GroupRequest\StoreGroupRequest;
use App\Http\Requests\GroupRequest\UpdateGroupRequest;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    public function index()
    {
        $groups = auth()->user()->groups()->get();

        return response([
            'data' => $groups
        ], 200);
    }

    public function store(StoreGroupRequest $request): Response
    {
        $group = Group::create([
            'administrator_id' => auth()->user()->getAuthIdentifier(),
            'name' => $request->get('name'),
        ]);

        auth()->user()->groups()->attach($group);

        return response($group, 201);
    }

    public function show(Group $group, ShowGroupRequest $request): Response
    {
        return response([
            'data' => $group
        ], 200);
    }

    public function update(UpdateGroupRequest $request, Group $group)
    {
        $group->update([
            'name' => $request->get('name'),
        ]);

        return response([
            'message' => 'success',
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteGroupRequest $request, Group $group)
    {
        $group->delete();

        return response([
            'message' => 'success',
        ], 200);
    }

    public function leave(LeaveGroupRequest $request, Group $group)
    {
        $group->users()->detach(auth()->user()->getAuthIdentifier());

        return response([
            'message' => 'success',
        ], 200);
    }

    public function kick(KickUserRequest $request, Group $group)
    {
        $user = User::findOrFail($request->get('user'));
        $group->users()->detach($user->id);

        return response([
            'message' => 'success',
        ], 200);
    }

    public function users(Group $group)
    {
        return response([
            'data' => $group->users
        ], 200);
    }
}
