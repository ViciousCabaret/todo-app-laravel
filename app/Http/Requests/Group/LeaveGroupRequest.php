<?php

namespace App\Http\Requests\Group;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class LeaveGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->getAuthIdentifier() == $this->group->administrator_id) {
            return false;
        }
        return true;
    }

    protected function failedAuthorization()
    {
        throw new \Exception("Administrator cannot leave group");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            ''
        ];
    }
}
