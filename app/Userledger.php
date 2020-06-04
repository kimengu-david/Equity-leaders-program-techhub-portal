<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userledger extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function twallets()
    {
        return $this->hasMany('App\Twallet');
    }
}