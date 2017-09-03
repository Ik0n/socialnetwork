<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes_for_comments extends Model
{
    protected $fillable = ['comment_id', 'user_id'];
    //
}
