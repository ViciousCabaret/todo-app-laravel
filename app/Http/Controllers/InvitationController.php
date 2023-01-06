<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invitation\InvitationRequest;
use App\Models\Group;
use App\Models\User;

class InvitationController extends Controller
{
    public function index(InvitationRequest $request)
    {
        $user = User::where('invitation_link', $request->get('invitationLink'))->firstOrFail();
        $group = Group::findOrFail($request->get('groupId'));

        $groupClone = clone $group;
        if ($groupClone->users->contains($user)) {
            return response("User is already in group", 409);
        }

        $user->groups()->attach($group);

        return $this->returnDefaultSingleDataResponse($user, 201);
    }
}
