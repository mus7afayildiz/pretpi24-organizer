<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    //
    protected $fillable = ['name'];
    protected $table = 't_tag';
    protected $primaryKey = 'tag_id';

    public function notes()
    {
        return $this->belongsToMany(Note::class, 'note_tag', 'tag_id', 'note_id')
                    ->using(NoteTag::class)
                    ->withTimestamps();
    }
}
