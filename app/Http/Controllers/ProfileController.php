<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileUpdateRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(ProfileUpdateRequest $request)
    {
        $user = auth()->user();
        if (!Hash::check($request->get('password'), $user->getAuthPassword())) {
            return response("Password is not correct", 409);
        }

        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
        ]);

        return $this->returnDefaultSingleDataResponse($user);
    }
}
