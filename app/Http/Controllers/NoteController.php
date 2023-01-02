<?php

namespace App\Http\Controllers;

use App\Http\Requests\Note\CreateNoteRequest;
use App\Http\Requests\Note\DeleteNoteRequest;
use App\Http\Requests\Note\ShowNoteRequest;
use App\Http\Requests\Note\UpdateNoteRequest;
use App\Models\Group;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{

    public function index(Request $request)
    {
        $group = Group::findOrFail($request->query('group'));

        return response([
            'data' => $group->notes()
        ]);
    }

    public function store(CreateNoteRequest $request)
    {
        $group = Group::findOrFail($request->get('group'));
        $group = clone $group;

        if (!$group->users->contains(auth()->user()->getAuthIdentifier())) {
            return response([
                'message' => 'User does not belong to this group',
            ], 401);
        }

        Note::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'priority' => $request->get('priority'),
            'group_id' => $group->id,
        ]);

        return $this->returnDefaultResponse();
    }

    public function show(ShowNoteRequest $request, Note $note)
    {
        return $this->returnDefaultDataResponse($note);
    }
    public function update(UpdateNoteRequest $request, Note $note)
    {
        $note->update([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'priority' => $request->get('priority'),
        ]);

        return $this->returnDefaultDataResponse($note);
    }

    public function destroy(DeleteNoteRequest $request, Note $note)
    {
        $note->delete();

        return $this->returnDefaultResponse();
    }
}
