<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Redirect;

use DB;
use Socialize;
use Session;
use Request;
use Hash;

class PassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $email = Session::get('email');
        $person = DB::select('SELECT * FROM Person p WHERE p.email=?', [$email]);

        $passengers = DB::select('SELECT * FROM Passenger ORDER BY rideDepartDateTime ASC');
        
        return view('passenger.index', ['passengers' => $passengers, 'name' => $person[0]->name, 'avatar' => $person[0]->avatar, 'email' => $person[0]->email, 'admin' => $person[0]->isadmin]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($passenger, $driver, $datetime)
    {
        $email = Session::get('email');
        $user = DB::select('SELECT * FROM Person p WHERE p.email=?', [$email]);

        // date_default_timezone_set('UTC');
        // $UTCdate = strtotime($datetime.' Asia/Singapore');
        // $formatted_datetime = date('y-m-d H:i:s', $UTCdate);

        $passengers = DB::select('SELECT * FROM Passenger p WHERE p.passengeremail=? AND p.ridedriveremail=? AND p.ridedepartdatetime=TO_TIMESTAMP(?, \'RR-MM-DD HH24:MI:SS\')', [$passenger, $driver, $datetime]);
        
        // foreach ($passengers[0] as $key => &$value) {
        //     if (in_array($key, ['ridedepartdatetime'])) {
        //         date_default_timezone_set('Asia/Singapore');
        //         $UTCdate = strtotime($value.' UTC');
        //         $value = date('d-m-y H:i:s', $UTCdate);
        //     }
        // }
        // unset($value);


        return view('passenger.show', ['passengers' => $passengers, 'name' => $user[0]->name, 'avatar' => $user[0]->avatar, 'email' => $user[0]->email, 'admin' => $user[0]->isadmin]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($passenger, $driver, $datetime)
    {
        $email = Session::get('email');
        $user = DB::select('SELECT * FROM Person p WHERE p.email=?', [$email]);

        // date_default_timezone_set('UTC');
        // $UTCdate = strtotime($datetime.' Asia/Singapore');
        // $formatted_datetime = date('y-m-d H:i:s', $UTCdate);

        $passengerz = DB::select('SELECT * FROM Passenger p WHERE p.passengeremail=? AND p.ridedriveremail=? AND p.ridedepartdatetime=TO_TIMESTAMP(?, \'RR-MM-DD HH24:MI:SS\')', [$passenger, $driver, $datetime]);
        
        // foreach ($passengerz[0] as $key => &$value) {
        //     if (in_array($key, ['ridedepartdatetime'])) {
        //         date_default_timezone_set('Asia/Singapore');
        //         $UTCdate = strtotime($value.' UTC');
        //         $value = date('d-m-y H:i:s', $UTCdate);
        //     }
        // }
        // unset($value);

        $passenger_details = array(
            'passengeremail' => $passengerz[0]->passengeremail,
            'ridedepartdatetime' => $passengerz[0]->ridedepartdatetime,
            'ridedriveremail' => $passengerz[0]->ridedriveremail
        );

        return view('passenger.edit', ['passengers' => $passenger_details, 'name' => $user[0]->name, 'avatar' => $user[0]->avatar, 'email' => $user[0]->email, 'admin' => $user[0]->isadmin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $passenger, $driver, $datetime)
    {
        $inputs = Request::all();

        $passengeremail = $inputs['passengeremail'];
        $ridedepartdatetime = $inputs['ridedepartdatetime'];

        // date_default_timezone_set('UTC');
        // $UTCdate = strtotime($ridedepartdatetime.' Asia/Singapore');
        // $formatted_datetime = date('y-m-d H:i:s', $UTCdate);

        $ridedriveremail = $inputs['ridedriveremail'];

        DB::update('UPDATE Passenger set passengeremail = ?, ridedepartdatetime = ?, ridedriveremail = ? WHERE passengeremail = ? AND ridedepartdatetime = ? AND ridedriveremail = ?', [$passengeremail, $ridedepartdatetime, $ridedriveremail, $passenger, $datetime, $driver]);

        return Redirect::to('/passengers/passenger/'.$passengeremail.'/driver/'.$ridedriveremail.'/datetime/'.$ridedepartdatetime);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($passenger, $driver, $datetime)
    {
        // date_default_timezone_set('UTC');
        // $UTCdate = strtotime($datetime.' Asia/Singapore');
        // $formatted_datetime = date('y-m-d H:i:s', $UTCdate);

        DB::delete('DELETE FROM Passenger p WHERE p.ridedriveremail=? AND p.passengeremail=? AND p.ridedepartdatetime=TO_TIMESTAMP(?, \'RR-MM-DD HH24:MI:SS\')', [$driver, $passenger, $formatted_datetime]);
        return Redirect::to('/passengers');
    }
}
