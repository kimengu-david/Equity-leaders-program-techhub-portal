<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{

    public function index()
    { //Storing the user details in a variable.

        //Limiting the number of posts that are shown in the homepage.
        $posts = DB::table('posts')->latest()->paginate(6); //->latest()->paginate(6);
        // $posts = $user->posts()->latest()->paginate(6);
        return view('profiles.index', compact('posts'));
    }

    public function edit(\App\User $user)
    {

        //Authorizing the update action on the particular profile
        //Trying to directly access this will give an action unauthorized error due to the policy enforced.
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);
//The auth() introduces an extra layer of protection by making sure that only the authenticated user is able
        //to make changes to the profile.

        if (request('image')) {

            $imagepath = request('image')->store('/profile', 'public');
            $image = Image::make(public_path("/storage/{$imagepath}"))->fit(200, 200);
            $image->save();

            $imageArray = ['image' => $imagepath];
        }

        //Testing the output of the merge//dd(array_merge($data, ['image' => $imagepath]));
        //The array_merge function will overrite the value of the image initially specified.

        auth()->user()->profile->update(array_merge($data,

            $imageArray ?? []));
        return redirect("/profile/{$user->id}");

    }
}