<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Note::query();

        // Etikete göre filtreleme
        if ($request->has('tag') && $request->tag != '') {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->tag);
            });
        }

        // **Anahtar kelime ile arama**
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                ->orWhere('content_markdown', 'like', "%{$searchTerm}%");
            });
        }
    
        // Notları ve etiketleri çek
        $notes = $query->with('tags', 'attachments')->get();
        $tags = Tag::all(); // Etiketleri al
    
        return view('notes.index', compact('notes', 'tags'));
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
            'tags.*' => 'exists:tags,tag_id',
            'attachments' => 'array',
            'attachments.*.filename' => 'required|string|max:255',
            'attachments.*.path' => 'required|string|max:255',
            'attachments.*.type' => 'required|string|max:255'
        ]);

        // Create new note
        $note = Note::create([
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
                $note->attachments()->create([
                    'filename' => $attachment['filename'],
                    'path' => $attachment['path'],
                    'type' => $attachment['type'],
                ]);
            }
        }
 
        return redirect()->route('notes.index');
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
