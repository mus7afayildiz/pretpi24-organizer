<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $fillable = ['name'];
    protected $table = 't_tag';
    protected $primaryKey = 'tag_id';
}
