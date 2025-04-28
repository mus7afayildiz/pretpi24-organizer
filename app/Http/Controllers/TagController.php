<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tag;
use App\Models\NoteTag;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{

    public function detach(Request $request, Tag $tag)
    {
        $noteId = $request->input('note_id');
    
        $note = Note::findOrFail($noteId);
    
        // Assurez-vous que l'utilisateur a une note
        if ($note->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        $note->tags()->detach($tag->id);
    
        return response()->json(['message' => 'Tag detached successfully', 200]);
    }

    public function store(Note $note, Tag $tag)
    {
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
    }

    /**
     * Supprimez la ressource spécifiée du stockage.
     */
    public function destroy(Tag $tag)
    {
        //supprimer la balise
        $tag->delete();
        return redirect()->route('notes.index');
    }


}
