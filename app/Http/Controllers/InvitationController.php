<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invitation\InvitationRequest;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function index(InvitationRequest $request)
    {
        $user = User::where('invitation_link', $request->get('invitationLink'))->firstOrFail();
        $group = Group::findOrFail($request->get('group'));

        $user->groups()->attach($group);

        return response([
            'message' => 'success'
        ], 200);
    }
}
