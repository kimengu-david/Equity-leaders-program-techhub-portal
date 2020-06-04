<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_member extends Model
{
    public function user()
    {
        return $this->guessBelongsToMany('App\User');
    }
}