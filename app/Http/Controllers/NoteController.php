<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $notes = Note::all(); 
 
        return view('notes.index', compact('notes')); 
    }

    public function adding()
    {
        $notes = Note::with(['tags', 'attachments'])->get();

        return response()->json($notes);
    }
    public function showIndexPage()
    {
        $notes = Note::with(['tags', 'attachments'])->get();
        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content_markdown' => 'required|string',
            'id' => 'required|exists:users,id',
            'tags' => 'array',
            'tags.*' => 'exists:t_tag,tag_id',
            'attachments' => 'array',
            'attachments.*.filename' => 'required|string|max:255',
            'attachments.*.path' => 'required|string|max:255',
            'attachments.*.type' => 'required|string|max:255'
        ]);

        //
        Note::create([
            'title' => $request->input('title'),
            'content_markdown' => $request->input('content_markdown'),
            'id' => $request->input('id')
        ]);

        // Associate tags
        if ($request->has('tags')) {
            $note->tags()->sync($request->tags);
        }

        // Save attachments
        if ($request->has('attachments')) {
            foreach ($request->attachments as $attachment) {
                Attachment::create([
                    'filename' => $attachment['filename'],
                    'path' => $attachment['path'],
                    'type' => $attachment['type'],
                    'note_id' => $note->note_id
                ]);
            }
        }
 
        //return redirect()->route('notes.index');
        return response()->json(['message' => 'Note created successfully', 'note' => $note], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        //
        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        //
        $note->update([
            'title' => $request->input('title'),
            'content_markdown' => $request->input('content_markdown'),
            'id' => $request->input('id')
        ]);

        return redirect()->route('notes.index'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        //
        $note->delete();
 
        return redirect()->route('notes.index');
    }
}
