<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    // Modèle pour gérer les pièces jointes liées aux notes.
    protected $fillable = ['filename', 'path', 'note_id'];
    protected $table = 't_attachment';
    protected $primaryKey = 'attachment_id';

    public function notes()
    {
        return $this->belongsToMany(Note::class, 'attachment_id', 'note_id');
    }
}
