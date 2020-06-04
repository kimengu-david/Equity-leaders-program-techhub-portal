<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api'); //->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set("Africa/Nairobi");
        DB::table('projects')->insert((['project_name' => $request['project_name'],
            "project_details" => $request['project_details'],
            "project_lead" => $request['project_lead'],
            "timeframe" => $request->timeframe,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')]));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $projects = DB::table('projects')
            ->orderByRaw('id DESC')
            ->get()->toArray();
        return $projects;
        //foreach ($projects as $project) {
        //dd("This is working");
        //}
        //  }
    }
    //return $projects;
    //}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('projects')
            ->where('id', $id)
            ->update($request->all());
    }

    public function register($id)
    {
        $user_id = Auth()->user()->id;
        $projects = DB::table('project_members')->where([
            ['user_id', '=', $user_id],
            ['projects_id', '=', $id],
        ])->count();

        if ($projects > 0) {
            return ['message' => 'true'];
        } else {

            DB::table('project_members')->insert(
                ['projects_id' => $id, 'user_id' => $user_id,

                ]
            );
        }
    }
    public function leave($id)
    {
        $user_id = Auth()->user()->id;
        DB::table('project_members')->where(['projects_id' => $id, 'user_id' => $user_id])->delete();

    }
    public function userProjects()
    {
        $id = strval(auth('api')->user()->id);

        $projects = DB::table('project_members')->where('user_id', '=', $id)->get();
        $totalprojects = $projects->count();
        return $totalprojects;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        DB::table('project_members')->where('projects_id', '=', $id)->delete();
        DB::table('projects')->where('id', '=', $id)->delete();

    }
}