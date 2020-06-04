<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Storage;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
class PostsController extends Controller
{
    //The below function will force every user to be authenticated before any of the methods that follow
    //are excecuted.

    //For the page where the user is redirected to after login.
    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);
        //For testing dd($posts);
        return view('posts.index', compact('posts'));
    }
    public function create()
    {
        return view('posts.create');
    }
    public function store(Request $request)
    {

        $data = request()->validate([
            'caption' => 'required',
         

        ]);

    
       $name = time() . '.' . explode('/', explode(':', substr($request->image, 0,strpos($request->image, ';')))[1])[1];
        $contents=\Image::make($request->image)->save(public_path('images/s3uploads/') . $name)->fit(1200, 1200);

           Storage::disk('s3')->put('postuploads/' .$name, $contents,'public');
       

        DB::table('posts')->insert([

            'caption' => $data['caption'],
            'image' => $name,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        return ['message' => 'Post created successfully'];
    }

  

    public function update(Request $request, $id)
    {
        if ($request->hasFile('photo')) {
            //

            $data = request()->validate([
                'caption' => 'required',

            ]);
            //return dd(request('image'));
            //$imagepath = request('image')->storeAs('/uploads', 'public');
            $name = time() . '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
           $contents= \Image::make($request->image)->save(public_path('images/s3uploads/') . $name)->fit(1200, 1200);
            
            Storage::disk('s3')->put('postuploads/' .$name, $contents,'public');
       
            $request->merge(['image' => $name]);
            // $image->save();

            DB::table('posts')->where('id', $id)->insert([

                'caption' => $data['caption'],
                'image' => 'uploads/' . $name,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {

            DB::table('posts')->where('id', $id)->update([

                'caption' => $request['caption'],

                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        //$this->authorize('isAdmin');
        //delete the post.
        $post->delete();

        //The servers response.

        return ['message' => 'User deleted'];
    }
}