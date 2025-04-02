<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //
    protected $fillable = ['user_id','title','content_markdown'];
    protected $table = 't_note';
    protected $primaryKey = 'note_id';

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'note_tag', 'note_id', 'tag_id')
                    ->using(NoteTag::class)
                    ->withTimestamps();
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'note_id');
    }
}
