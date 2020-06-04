<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;

class AuthController extends Controller
{
//{public function __construct()
    //{
    //$this->middleware('guest', ['except' => 'logout']);
    //}
    //$this->middleware('auth')->except(['index', 'show']);
    //}

    public function index()
    {
        return view('auth/login');

    }

//The function that returns the registration view.
    public function registrationForm()
    {
        return view('auth.customRegister.register');
    }

    public function postLogin(Request $request)
    {

        request()->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            //return redirect()->intended('dashboard');
            return response()->json(['redirect' => '/dashboard']);
        } else {
            // return Redirect()->intended('facebook.com');
            return response()->json(['error' => 'wrong credentials!'], 500);
        }
        //catch (NotActivatedException $e) {
        // $delay = $e->getDelay();
        // return response()->json(['error' => 'You are banned for $delay seconds!'], 500);

        //}

    }

    public function registerUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',

        ]);

        if ($validator->fails()) {
            ?> <script>
alert("user already exists..Try a different email address")
window.location.href = "/register";;
</script><?php

        } else {
            $data = $request->all();
            $check = $this->create($data);
            ?> <script>
alert("Account successfully created\ngo to homepage and choose login");
window.location.href = "/home";
</script><?php

        }
    }

    public function dashboard()
    {
        //$one = (date('Y-m-d H:i:s'));
        // $two = (date('Y-m-d H:i:s'));
        // $date1 = date_create($one);
        //$date2 = date_create($two);
        //dd(date_diff($date1, $date2, )->format('%a'));
        //Storing the user details in a variable.
        $user = Auth::user();
        $user_id = $user->id;
        $projects = DB::table('projects')->count();
        $meetups = DB::table('meetups')->count();
        $myprojects = DB::table('project_members')->where('user_id', '=', $user_id)->get();
        $mytotalprojects = DB::table('project_members')->where('user_id', '=', $user_id)->count();
        $totalnotifications = $projects + $meetups;
        //$projects = DB::table('projects')->count();

        return view('auth/dashboard', compact('user', 'mytotalprojects', 'projects', 'myprojects', 'meetups', 'totalnotifications'));

        //Initial code

        //if(Auth::check()){
        // return view('auth/dashboard');
        // }
        // return Redirect::to("login")->withSuccess('Opps! You do not have access');
    }
    //End of initial code.

    public function create(array $data)
    {
        return User::create([

            'email' => $data['email'],
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'gender' => $data['gender'],
            'username' => $data['username'],
            'cont' => $data['cont'],
            'address' => $data['address'],
            'school' => $data['school'],
            'course' => $data['course'],
            'year' => $data['year'],
            'github' => $data['github'],
            'linkedin' => $data['linkedin'],
            'skills' => $data['skills'],

            'password' => Hash::make($data['pass']),
        ]);
    }

    public function logout()
    { //The session flush section was  initially active, commented for checking csrf with ajax
        //Session::flush();
        Auth::logout();
        return Redirect('/');
    }
}