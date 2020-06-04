<?php

namespace App;

use App\Mail\NewUserWelcomeMail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'image', 'fname', 'lname', 'school', 'course', 'year', 'gender', 'cont', 'github', 'linkedin', 'skills', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function meetups()
    {
        return $this->belongsToMany('App\Meetup');
    }
    public function posts()
    {
        return $this->hasMany('App\Post')->orderBy('created_at', 'DESC');
    }

    public function following()
    {
        return $this->belongsToMany('App\Profile');
    }
    public function twallets()
    {
        return $this->hasMany('App\Twallet');
    }

    public function profile()
    {

        return $this->hasOne('App\Profile');

    }
    public function userledger()
    {
        return $this->hasOne('App\Userledger');
    }
    public function message()
    {
        return $this->hasMany('App\Message');
    }
    public function project_member()
    {
        return $this->hasMany('App\Project_member');
    }

    //public function meetupAttendee()
    //{
    // return $this->hasMany('App\Meetup_attendee');
    // }
    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->profile()->create([
                'title' => $user->username,
            ]);

//The following method will send the mail but is not the recommended method in development.
            Mail::to($user->email)->send(new NewUserWelcomeMail());

        }

        );
    }
}