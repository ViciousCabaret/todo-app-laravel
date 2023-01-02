<?php

namespace App\Http\Requests\GroupRequest;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Http\FormRequest;

class KickUserRequest extends FormRequest
{
    private bool $notAdmin = false;
    private bool $adminToDelete = false;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();
        if ($user->getAuthIdentifier() != $this->group->administrator_id) {
            $this->notAdmin = true;
            return false;
        }
        if ($user->getAuthIdentifier() == $this->user) {
            $this->adminToDelete = true;
            return false;
        }
        return true;
    }

    protected function failedAuthorization()
    {
        if ($this->notAdmin) {
            throw new AuthenticationException("Unauthenticated.");
        }
        if ($this->adminToDelete) {
            throw new AuthenticationException("Administrator cannot leave group");
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user' => 'int|required'
        ];
    }
}
