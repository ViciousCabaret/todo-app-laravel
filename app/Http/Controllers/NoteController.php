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
        return $this->returnDefaultDataResponse($group->notes()->get());
    }

    public function store(CreateNoteRequest $request)
    {
        $group = Group::findOrFail($request->get('group_id'));

        $cloneGroup = clone $group;
        if (!$cloneGroup->users->contains(auth()->user()->getAuthIdentifier())) {
            return response([
                'message' => 'User does not belong to this group',
            ], 401);
        }

        $note = Note::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'priority' => 0,
            'group_id' => $group->id,
        ]);

//        $group->notes()->attach($note);

        return $this->returnDefaultSingleDataResponse($note, 201);
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
