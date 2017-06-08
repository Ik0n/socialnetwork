<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected  $fillable = ['filename', 'user_id_recipient', 'user_id_sender'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
