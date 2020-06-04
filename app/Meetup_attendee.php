<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meetup_attendee extends Model
{

    public function user()
    {
        return $this->BelongsToMany('App\User')->withPivot('column3');
    }
}