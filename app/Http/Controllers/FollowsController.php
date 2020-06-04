<?php

namespace App\Http\Controllers;

use App\User;

class FollowsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(\App\User $user)
    {

        return auth()->user()->following()->toggle($user->profile);
        //for testing return $user->username;
    }
}