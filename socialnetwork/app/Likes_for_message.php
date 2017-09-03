<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes_for_message extends Model
{
    protected $fillable = ['message_id', 'user_id'];
    //
}
