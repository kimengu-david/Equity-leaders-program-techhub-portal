<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{ //The below method overrides the mass assignment constrain on laravel.
    protected $guarded = [];

    public function profileImage()
    {
        $imagePath = ($this->image) ? $this->image : '/profile/Yzn6SkSacZZGvOSzNNIiZcBXFOwmvcEC5wUFmswc.png';
        return '/storage/' . $imagePath;
    }
    public function followers()
    {
        return $this->belongsToMany('App\User');
    }
    public function user()
    {

        return $this->belongsTo('App\User');
    }
}