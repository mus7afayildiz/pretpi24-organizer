<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class NoteTag extends Pivot
{
    protected $table = 'note_tag';
}
