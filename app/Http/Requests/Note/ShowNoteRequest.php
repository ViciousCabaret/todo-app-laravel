<?php

namespace App\Http\Requests\Note;

use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;

class ShowNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $group = Group::findOrFail($this->note->group_id);
        $group = clone $group;
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
