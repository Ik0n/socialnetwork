<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usergroup extends Model
{
    public function userGroup() {
    	return $this->belongsToMany(App\Usergroup::class);
    }
}
