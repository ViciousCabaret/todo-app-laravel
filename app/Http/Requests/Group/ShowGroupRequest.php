<?php

namespace App\Http\Requests\Group;

use Illuminate\Foundation\Http\FormRequest;

class ShowGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $group = clone $this->group;
        if (!$group->users->contains(auth()->user()->getAuthIdentifier())) {
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
            //
        ];
    }
}
