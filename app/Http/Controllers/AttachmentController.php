<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tag;
use App\Models\NoteTag;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttachmentController extends Controller
{

        public function destroy(Attachment $attachment)
    {
        $note = $attachment->note;

        if (!$note || $note->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $filePath = public_path($attachment->path);

        // Dosya varsa sil
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $attachment->delete();

        return response()->json(['message' => 'Attachment deleted']);
    }


}
