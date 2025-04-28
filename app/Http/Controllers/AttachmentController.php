<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tag;
use App\Models\NoteTag;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{

    public function store(Request $request, Note $note)
    {
        // Vérification de l'existence d'une note
        $note = Note::findOrFail($note->note_id);
        
        // Vérifier l'utilisateur actuel
        if ($note->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Vérification des fichiers
        // $request->validate([
        //     'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt|max:10240', // Maksimum 10MB
        // ]);

        // Créer une pièce jointe
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = $file->getClientOriginalName();
            $path = $file->store('attachments');
    
            // Ajouter des pièces jointes
            Attachment::create([
                'filename' => $filename,
                'path' => $path,
                'note_id' => $note->note_id // Association avec le bon note_id
            ]);
        }

        return redirect()->route('notes.index')->with('success', 'Attachment added successfully.');
    }

    
    public function removeAttachment($attachmentId)
    {
        // Attachment'ı bul
        $attachment = Attachment::findOrFail($attachmentId);

        // Dosyayı sunucudan sil (dosya yolu 'path' kolonu ile alınır)
        if (file_exists(public_path($attachment->path))) {
            unlink(public_path($attachment->path));
        }

        // Attachment'ı veritabanından sil
        $attachment->delete();

        return response()->json(['message' => 'Attachment removed successfully.']);
    }



    public function destroy(Attachment $attachment, Note $note)
    {
        // Vérifiez s'il est associé à la note de l'utilisateur
        $note = $attachment->note;

        // Obtenir le chemin du fichier et supprimer le fichier du serveur
        $filePath = public_path($attachment->path);

        if (file_exists($filePath)) {
            unlink($filePath); // Supprimer le fichier
        }

        // Supprimer la pièce jointe de la base de données
        $attachment->delete();

        return redirect()->route('notes.index')->with('success', 'Attachment deleted successfully.');
    }

}
