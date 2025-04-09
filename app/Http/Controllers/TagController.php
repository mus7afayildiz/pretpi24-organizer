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
    
        // Kullanıcının notu olduğundan emin ol
        if ($note->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        $note->tags()->detach($tag->id);
    
        return response()->json(['message' => 'Tag detached successfully', 200]);
    }

        /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        //
    }

}
