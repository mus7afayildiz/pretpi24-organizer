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

    // Add tag to note
    public function addTag(Request $request, Note $note)
    {
        // Obtenir tag
        $tag = Tag::find($request->tag_id);

        if (!$tag) {
            return back()->with('error', 'Tag not found.');
        }

        // Association à une note
        $note->tags()->attach($tag->tag_id);

        // Redirection avec message de réussite
        return back()->with('success', 'Tag added successfully.');
    }

    /**
     * Supprimer la connexion entre tag et note
     */
    public function removeTag(Note $note, Tag $tag)
    {
        $note->tags()->detach($tag->tag_id);

        return  back()->with('success', 'Tag deleted successfully.');
    }


    public function removeTagFromNote($noteId, $tagId)
    {
        // Trouver la note
        $note = Note::findOrFail($noteId);

        // Trouver la balise
        $tag = Tag::findOrFail($tagId);

        //Supprimer la balise de l'association avec la note
        $note->tags()->detach($tagId);

        return response()->json(['message' => 'Tag removed successfully.']);
    }


    /**
     * Afficher une liste de la ressource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Note::with(['tags', 'attachments'])->where('user_id', $user->id);

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

        $notesQuery = Note::with(['tags', 'attachments'])->where('user_id', Auth::id());

        $tags = Tag::all(); // Pour les cases à cocher
        
        // Obtenir les cases à cocher sous forme de tableau
        if ($request->has('tags')) {
            $selectedTags = $request->input('tags', []);
        
            $notesQuery->whereHas('tags', function ($query) use ($selectedTags) {
                $query->whereIn('name', $selectedTags);
            });
        } else {
            $selectedTags = [];
        }
        
        $notes = $notesQuery->get();
        
        return view('notes.index', compact('notes', 'tags', 'selectedTags'));
    }

    public function showIndexPage()
    {
        $notes = Note::with(['tags', 'attachments'])->get();
        return view('notes.index', compact('notes'));
    }

    /**
     * Afficher le formulaire de création d'une nouvelle ressource.
     */
    public function create()
    {
        //
        return view('notes.create');
    }

    /**
     * Stockez une ressource nouvellement créée dans le stockage.
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

        // Créer une note
        $note = Note::create([
            'title' => $request->title,
            'content_markdown' => $request->content_markdown,
            'user_id' => Auth::id()
        ]);

        // Créer une balise
        if ($request->has('tag')) {
            $tag = Tag::create([
                'name' => $request->tag,
            ]);
            
            $noteTag = NoteTag::create([
                'note_id' => $note->note_id,
                'tag_id' => $tag->tag_id, 
            ]);
        }

        // Créer une pièce jointe
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = $file->getClientOriginalName();
            $path = $file->store('attachments');
        
            Attachment::create([
                'filename' => $filename,
                'path' => $path,
                'note_id' => $note->note_id,
            ]);
        }
         
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
     * Afficher le formulaire pour modifier la ressource spécifiée.
     */
    public function edit(Note $note)
    {
        //
        return view('notes.edit', compact('note'));
    }

    /**
     * Mettre à jour la ressource spécifiée dans le stockage.
     */
    public function update(Request $request, Note $note, Tag $tag)
    {
        // Modifier la note
        $note->update([
            'title' => $request->input('title'),
            'content_markdown' => $request->input('content_markdown'),
            'user_id' => Auth::id()
        ]);

        if ($request->has('tag') && !empty($request->input('tag'))) {
            $tag = Tag::create([
                'name' => $request->input('tag'),
            ]);

            $note_tag = NoteTag::create([
                'note_id' => $note->note_id,
                'tag_id' => $tag->tag_id,
            ]);
        }

        // Créer une pièce jointe
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = $file->getClientOriginalName();
            $path = $file->store('attachments');
        
            Attachment::create([
                'filename' => $filename,
                'path' => $path,
                'note_id' => $note->note_id,
            ]);
        }

        return redirect()->route('notes.index'); 
    }

    /**
     * Supprimez la ressource spécifiée du stockage.
     */
    public function destroy(Note $note)
    {
        //supprimer la note
        $note->delete();
 
        return redirect()->route('notes.index');
    }
}
