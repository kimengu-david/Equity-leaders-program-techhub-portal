<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Twallet extends Model
{

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function userledgers()
    {
        return $this->belongsTo('App\Userledger');
    }
}