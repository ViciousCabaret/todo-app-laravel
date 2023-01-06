<?php

namespace App\Http\Requests\Invitation;

use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;

class InvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $group = Group::findOrFail($this->groupId);
        $group = clone $group;
        if (auth()->user()->getAuthIdentifier() != $group->administrator_id) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'invitationLink' => 'string|required',
            'groupId' => 'integer|required',
        ];
    }
}
