<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //
    protected $fillable = ['id','title','content_markdown'];
    protected $table = 't_note';
    protected $primaryKey = 'note_id';

    public function users()
    {
        return $this->belongsToMany(User::class, 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'add', 'note_id', 'tag_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'note_id');
    }
}
