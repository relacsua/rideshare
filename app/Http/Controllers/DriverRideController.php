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

class DriverRideController extends Controller
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

        $driverrides = DB::select('SELECT * FROM Driver_Ride');

        foreach ($driverrides as &$driverride) {
            foreach ($driverride as $key => &$value) {
                if (in_array($key, ['departdatetime'])) {
                    date_default_timezone_set('Asia/Singapore');
                    $UTCdate = strtotime($value.' UTC');
                    $value = date('d-m-y H:i:s', $UTCdate);
                }
            }
            unset($value);
        }
        unset ($driverride);
        
        return view('driverride.index', ['driverrides' => $driverrides, 'name' => $person[0]->name, 'avatar' => $person[0]->avatar, 'email' => $person[0]->email, 'admin' => $person[0]->isadmin]);
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
    public function show($driver, $datetime)
    {
        $email = Session::get('email');
        $user = DB::select('SELECT * FROM Person p WHERE p.email=?', [$email]);

        date_default_timezone_set('UTC');
        $UTCdate = strtotime($datetime.' Asia/Singapore');
        $formatted_datetime = date('y-m-d H:i:s', $UTCdate);

        $driverride = DB::select('SELECT * FROM Driver_Ride r WHERE r.driveremail=? AND r.departdatetime=TO_TIMESTAMP(?, \'DD-MM-RR HH24:MI:SS\')', [$driver, $formatted_datetime]);
        foreach ($driverride[0] as $key => &$value) {
            if (in_array($key, ['departdatetime'])) {
                date_default_timezone_set('Asia/Singapore');
                $UTCdate = strtotime($value.' UTC');
                $value = date('d-m-y H:i:s', $UTCdate);
            }
        }
        unset($value);

        return view('driverride.show', ['driverrides' => $driverride, 'name' => $user[0]->name, 'avatar' => $user[0]->avatar, 'email' => $user[0]->email, 'admin' => $user[0]->isadmin]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($driver, $datetime)
    {
        $email = Session::get('email');
        $user = DB::select('SELECT * FROM Person p WHERE p.email=?', [$email]);
        
        date_default_timezone_set('UTC');
        $UTCdate = strtotime($datetime.' Asia/Singapore');
        $formatted_datetime = date('y-m-d H:i:s', $UTCdate);

        $driverride = DB::select('SELECT * FROM Driver_Ride r WHERE r.driveremail=? AND r.departdatetime=TO_TIMESTAMP(?, \'DD-MM-RR HH24:MI:SS\')', [$driver, $formatted_datetime]);
        
        foreach ($driverride[0] as $key => &$value) {
            if (in_array($key, ['departdatetime'])) {
                date_default_timezone_set('Asia/Singapore');
                $UTCdate = strtotime($value.' UTC');
                $value = date('d-m-y H:i:s', $UTCdate);
            }
        }
        unset($value);

        $driverride_details = array(
            'departdatetime' => $driverride[0]->departdatetime,
            'departlocation' => $driverride[0]->departlocation,
            'destination' => $driverride[0]->destination,
            'driveremail' => $driverride[0]->driveremail,
            'priceperseat' => $driverride[0]->priceperseat,
            'numseats' => $driverride[0]->numseats,
            'iscancelled' => $driverride[0]->iscancelled,
            'isstarted' => $driverride[0]->isstarted,
            'isended' => $driverride[0]->isended
        );

        return view('driverride.edit', ['driverrides' => $driverride_details, 'name' => $user[0]->name, 'avatar' => $user[0]->avatar, 'email' => $user[0]->email, 'admin' => $user[0]->isadmin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $driver, $datetime)
    {
        $inputs = Request::all();

        $departdatetime = $inputs['departdatetime'];

        date_default_timezone_set('UTC');
        $UTCdate = strtotime($departdatetime.' Asia/Singapore');
        $formatted_datetime = date('y-m-d H:i:s', $UTCdate);

        $departlocation = $inputs['departlocation'];
        $destination = $inputs['destination'];
        $driveremail = $inputs['driveremail'];
        $priceperseat = $inputs['priceperseat'];
        $numseats = $inputs['numseats'];
        $iscancelled = $inputs['iscancelled'];
        $isstarted = $inputs['isstarted'];
        $isended = $inputs['isended'];

        DB::update('UPDATE Driver_Ride set departdatetime = TO_TIMESTAMP(?, \'DD-MM-RR HH24:MI:SS\'), departlocation = ?, destination = ?, driveremail = ?, priceperseat = ?, numseats = ?, iscancelled = ?, isstarted = ?, isended = ?  WHERE driveremail = ? AND departdatetime = TO_TIMESTAMP(?, \'DD-MM-RR HH24:MI:SS\')', [$formatted_datetime, $departlocation, $destination, $driveremail, $priceperseat, $numseats, $iscancelled, $isstarted, $isended, $driveremail, $formatted_datetime]);

        return Redirect::to('/driverrides/driver/'.$driver.'/datetime/'.$datetime);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($driver, $datetime)
    {
        date_default_timezone_set('UTC');
        $UTCdate = strtotime($datetime.' Asia/Singapore');
        $formatted_datetime = date('y-m-d H:i:s', $UTCdate);

        DB::delete('DELETE FROM Driver_Ride r WHERE r.driveremail=? AND r.departdatetime=TO_TIMESTAMP(?, \'DD-MM-RR HH24:MI:SS\')', [$driver, $formatted_datetime]);
        return Redirect::to('/driverrides');
    }
}
