<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{ 
    //
    protected $fillable = ['titre','title', 'text', 'category_id'];
}
