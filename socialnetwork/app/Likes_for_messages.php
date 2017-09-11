<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes_for_messages extends Model
{
    protected $fillable = ['message_id', 'user_id'];
    //
}
