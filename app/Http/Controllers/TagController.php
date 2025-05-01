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

    public function store(Request $request, Note $note, Tag $tag)
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {

        return redirect()->route('categories.index'); 
    }

    /**
     * Supprimez la ressource spécifiée du stockage.
     */
    public function destroy(Tag $tag)
    {
        $tag = Tag::findOrFail($tag->tag_id);

        \Log::info("La balise est supprimée : " . $tag->tag_id);

        //supprimer la balise
        $tag->notes()->detach();
        $tag->delete();
        return redirect()->route('categories.index');
    }
}
