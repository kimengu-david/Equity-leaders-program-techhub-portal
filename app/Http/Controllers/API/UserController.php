<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Auth;
use App\Http\Controllers\Controller;
use App\Twallet;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDF;
use Storage;
class UserController extends Controller
{
    //The below method is meant to protect the routes.
    public function __construct()
    {
        $this->middleware('auth:api'); //->except(['index', 'show', 'usersArray']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'username' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:8',

        ]);
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'username' => $request['username'],
            'role' => $request['role'],
            'password' => Hash::make($request['password']),

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function twallet()
    {
        //Shows how to run a query on a specific table.
        $twallets = DB::table('userledgers')->orderByRaw('balance DESC')->get();
        return ($twallets);

    }

    public function generateInvoice($id)
    {
        //Shows how to run a query on a specific table.
        $current_balance = (Integer) DB::table('userledgers')->where('user_id', $id)->select('balance')->value('balance');
        $fname = (string) DB::table('users')->where('id', $id)->select('fname')->value('fname', 'lname');
        $lname = (string) DB::table('users')->where('id', $id)->select('lname')->value('lname', 'lname');
        $statements = DB::table('twallets')->where('user_id', $id)->get();
        $fullname = $fname . "  " . $lname;
        $date = date('Y-m-d H:i:s');
        $user = User::findOrFail($id);
        $pdf = PDF::loadView('pdf_statement', compact('statements', 'date', 'user', 'current_balance', 'fullname'));
        $pdf->download('statement.pdf');
        //$pdf->setOption('encoding', 'UTF-8');
        return base64_encode($pdf->output());

    }

    public function updatetwallet(Request $request)
    {$this->validate($request, [
        'user_id' => 'required|string|max:191',
        'amount' => 'required|integer|max:2000000000000',
        'type' => 'required|string|max:191',
        //The last part means that the email must be unique but should skip the current user.
        'transaction_details' => 'required|string|max:191',

    ]);
        $transaction_amount = $request->input('amount');
        $type = $request->input('type');
        $transaction_details = $request->input('transaction_details');
        $stuff = $request->input('fname') . " " . $request->input('lname');
        $user_id = $request->input('user_id');

        //step one check if the user exists in the unique transactions ledger.
        $exists = DB::table('userledgers')->where('user_id', $user_id)->exists();
        if ($exists) {

            //The pluck function in eloquent that specifies a specific column value is depricated.
            $current_balance = (Integer) DB::table('userledgers')->where('user_id', $user_id)->select('balance')->value('balance');

            if ($type == "Credit") {
                $new_balance = $current_balance + $transaction_amount;
            } else if ($type == "Debit") {
                $new_balance = $current_balance - $transaction_amount;

            }
            DB::table('userledgers')
                ->where('user_id', $user_id)
                ->update(['balance' => $new_balance, 'updated_at' => date('Y-m-d H:i:s')]);
            //posting into transactions history ledger.
            $data = array('user_id' => $user_id, 'updated_at' => date('Y-m-d H:i:s'), 'amount' => $transaction_amount, "transaction_details" => $transaction_details, "Type" => $type, "posted_by" => $stuff);
            DB::table('twallets')
                ->insert(
                    $data
                );

        } else {

            //post an entry into the transactions history ledger
            $data = array('user_id' => $user_id, 'created_at' => date('Y-m-d H:i:s'), "amount" => $transaction_amount, "transaction_details" => $transaction_details, "posted_by" => $stuff, "Type" => $type);
            DB::table('twallets')
                ->updateOrInsert(
                    $data
                );
            //Create an entry into the unique transactions leger.
            DB::table('userledgers')
                ->updateOrInsert(
                    ['user_id' => $user_id, 'created_at' => date('Y-m-d H:i:s'), 'balance' => $transaction_amount]
                );

        }
    }

    public function profile()
    {
        return auth('api')->user();
    }
    public function meetup()
    {
        $id = strval(auth('api')->user()->id);
        //$users = DB::table('mee')->distinct()->get();
        $meetups = DB::table('meetup_user')->where('user_id', '=', $id)->get();
        $totalmeetups = $meetups->count();
        return $totalmeetups;
    }
    public function myProjects()
    {
        $id = strval(auth('api')->user()->id);
        //$users = DB::table('mee')->distinct()->get();
        $myProjects = DB::table('project_members')->where('user_id', '=', $id)->get();

        return $myProjects;
    }
    public function post()
    {
        //$users = DB::table('mee')->distinct()->get();
        $posts = DB::table('posts')->get();

        return $posts;
    }
    public function fetchTotal()
    {

        $total = DB::table('userledgers')->sum('balance');

        return $total;
    }

    public function showtwallet()
    {
        return auth('api')->user()->userledger;
    }

    public function updateProfile(Request $request)
    {$user = auth('api')->user();

        $this->validate($request, [

            'username' => 'required|string|max:191',
            //The last part means that the email must be unique but should skip the current user.
            'email' => 'required|string|email|max:191|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8',

        ]);

        
            $name = time() . '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
           $contents=\Image::make($request->image)->save(public_path('images/s3uploads/') . $name);


            
            Storage::disk('s3')->put('profiles/' .$name, $contents,'public');
       




            //Assigning a new value to the image field.
            //$request->image = $name;
            $request->merge(['image' => $name]);
           

        
        $user->update($request->all());

        return ['message' => "success"];
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {$user = User::findOrFail($id);
        $this->validate($request, [

        ]);
        $user->update($request->all());
        return ['message' => 'User role changed'];
    }

    public function search()
    {

        if ($search = \Request::get('q')) {
            $users = User::where(function ($query) use ($search) {
                $query->where('fname', 'LIKE', "%$search%")
                    ->orWhere('lname', 'LIKE', "%$search%")
                    ->orWhere('id', 'LIKE', "%$search%")
                    ->orWhere('role', 'LIKE', "%$search%");
            })->paginate(20);
        } else {
            $users = User::latest()->paginate(5);
        }

        return $users;

    }

    public function usersdownload()
    {return User::oldest()->paginate(1000000000000000000000);
        //$users = DB::table('mee')->distinct()->get();
        //$users = DB::table('users')->get(); //->toArray();
        //$myusers = (array) $users;

        //return $users;

        //$kk = array_shift($users);
        //dd($kk);
        //$array = json_decode(json_encode($users), true);
        //return ($users);
        //$pdf = PDF::loadView('pdf_view', compact('data'));
        // return $pdf->download('elptechhub members.pdf');
        // $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($users));
        //$list = iterator_to_array($it, false);
        //$myArray = json_decode(json_encode($users), true);
        // dd(($myArray[0]['fname']));
        //foreach ($users as $user) {
        // dd($user->fname);
        //}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('isAdmin');
        //delete the user.
        $user->userledger()->delete();
        $user->message()->delete();
        $user->twallets()->delete();
        $user->meetups()->detach();
        $user->project_member()->delete();
        $user->profile()->delete();
        $user->posts()->delete();
        $user->delete();
        //The servers response.

        return ['message' => 'User deleted'];
    }
}