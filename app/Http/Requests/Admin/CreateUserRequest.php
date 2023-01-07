<?php

namespace App\Http\Requests\Admin;

use App\Rules\PasswordType;
use Illuminate\Foundation\Http\FormRequest;
use Mockery\Generator\StringManipulation\Pass\Pass;

class CreateUserRequest extends AdminRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|unique:users|email',
            'password' => ['required', 'string', 'confirmed', new PasswordType],
            'roles' => 'required|array',
            'invitation_link' => 'string'
        ];
    }
}
