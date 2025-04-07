<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tag;
use App\Models\NoteTag;
use App\Models\Attachment;
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

        // Filtrer par tag
        if ($request->has('tag') && $request->tag != '') {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->tag);
            });
        }

      // Recherche par mot-clé
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                ->orWhere('content_markdown', 'like', "%{$searchTerm}%");
            });
        }
    
        // Récupérer des notes et des balises
        $notes = $query->with('tags', 'attachments')->get();
        $tags = Tag::all(); // Obtenir des étiquettes
    
        return view('notes.index', compact('notes', 'tags'));
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
        // Validation
        $request->validate([
            'title' => 'required|string|max:255',
            'content_markdown' => 'required|string',
            'tags' => 'array',
            'tags.*' => 'exists:t_tag,tag_id',
            'attachments' => 'array',
            'attachments.*.filename' => 'required|string|max:255',
            'attachments.*.path' => 'required|string|max:255',
            'attachments.*.type' => 'required|string|max:255'
        ]);

        // Create note
        $note = Note::create([
            'title' => $request->title,
            'content_markdown' => $request->content_markdown,
            'user_id' => Auth::id()
        ]);

        // Create tag
        // $tag = Tag::create([
        //     'name' => $request->tag,
        // ]);
        
        // $noteTag = NoteTag::create([
        //     'note_id' => 1,
        //     'tag_id' => 1, 
        // ]);
        //dd($request->all());

        // Create attachment
        // if ($request->has('attachment') && $request->has('path')) {
        //     $attachment = Attachment::create([
        //         'filename' => $request->input('attachment'),
        //         'path' => $request->input('path'),
        //         'note_id' => 1, // Lier l'attachment à la note
        //     ]);

        // }
        
         
        

        /*
        // Associate tags
        if ($request->has('tags')) {
            foreach ($request->tags as $tagId) {
                $note->tags()->attach($tagId); // Ajout de relations avec des balises
            }
        }*/
        

        /*
        // Save attachments
        if ($request->has('attachments')) {
            foreach ($request->attachments as $attachment) {
                $note->attachments()->create([
                    'filename' => $attachment['filename'],
                    'path' => $attachment['path'],
                    'type' => $attachment['type'],
                ]); 
            }
        }*/


        //dd($note->tags, $note->attachments);
 
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
    public function update(Request $request, Note $note, Tag $tag)
    {
        // Edit note
        $note->update([
            'title' => $request->input('title'),
            'content_markdown' => $request->input('content_markdown'),
            'id' => $request->input('id')
        ]);

        //dd($request->all());

        if ($request->has('tag')) {
            $tag = Tag::create([
                'name' => $request->tag,
            ]);

            $note_tag = NoteTag::create([
                'note_id' => $request->note,
                'tag_id' => $request->tag,
            ]);
        }

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
