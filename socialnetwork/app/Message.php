<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['content','user_id_recipient','user_id_sender','filename', 'private'];

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->belongsTo(Comment::class);
    }

    public function likes_for_messages() {
        return $this->belongsToMany(User::class, 'likes_for_message');
    }

    public function likes_for_comments() {
        return $this->belongsToMany(User::class, 'likes_for_comment');
    }

}