<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    //
    protected $fillable = ['filename', 'path'];
    protected $table = 't_attachment';
    protected $primaryKey = 'attachment_id';

    public function notes()
    {
        return $this->belongsTo(Note::class, 'note_id');
    }
}
