<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Meetup;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class MeetupController extends Controller
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
        $this->validate($request, [
            'Agenda' => 'required|string|max:191',
            'Time' => 'required|string|max:191',
            'Date' => 'required|string|date|max:191|',
            'organizer' => 'required|string|max:191',
            'regdeadline' => 'required|date|string|max:191',

        ]);

        date_default_timezone_set("Africa/Nairobi");
        DB::table('meetups')->insert((['Venue' => $request['Venue'],
            "Agenda" => $request['Agenda'],
            "Time" => $request['Time'],
            "Date" => $request['Date'],
            "regdeadline" => $request['regdeadline'],
            "organizer" => $request['organizer'],
            "additionalInfo" => $request['additionalInfo'],

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
        $meetups = DB::table('meetups')
            ->orderByRaw('id DESC')
            ->get();

        return $meetups;
    }
    public function attendees($id)
    {
        $details = DB::table('meetups')->where('id', $id)->get();

        $meetup = Meetup::findorfail($id);

        $data = $meetup->user;
        if (($data->count() == 0)) {
            return ["message" => "No users registerd"];
        } else {
            $pdf = PDF::loadView('pdf_attendeeView', compact('data', 'details'));
            $pdf->download('meetups.pdf');
            //$pdf->setOption('encoding', 'UTF-8');
            return base64_encode($pdf->output());
            //return ($pdf->output());
            //$pdf->r();
            //$pdf->stream();
            //return $pdf->stream("order_email.pdf");
            //file_put_contents("order_email.pdf", $pdf->output());
            //$pdf->stream('meetup.pdf');
            //return["message"=>"saved"];
            //$output = $pdf;
            //file_put_contents('meetups.pdf', $output);*/
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('meetups')
            ->where('id', $id)
            ->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('meetup_user')->where('meetup_id', '=', $id)->delete();
        DB::table('meetups')->where('id', '=', $id)->delete();
    }

    public function register($id)
    {
        $user_id = Auth()->user()->id;
        $meetups = DB::table('meetup_user')->where([
            ['user_id', '=', $user_id],
            ['meetup_id', '=', $id],
        ])->count();

        if ($meetups > 0) {
            return ['message' => 'true'];
        } else {

            Auth()->user()->meetups()->attach($id);
            //DB::table('meetup_user')->insert(
            // ['meetup_id' => $id, 'user_id' => $user_id,

            //]
            //);
        }
    }
    public function check($id)
    {$user_id = Auth()->user()->id;

        $meetups = DB::table('meetup_user')->where([
            ['attendee_id', '=', $user_id],
            ['created meetups_id', '=', $id],
        ])->count();

        if ($meetups > 0) {
            return ('true');
        } else {
            return ('false');
        }
    }
}