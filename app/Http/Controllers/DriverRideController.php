<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Redirect;
use App\Library\Location;

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

        $driverrides = DB::select('SELECT * FROM Driver_Ride ORDER BY departDateTime ASC');

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
        $driverride = DB::select("SELECT * FROM Driver_Ride r WHERE r.driveremail=? AND r.departdatetime=TO_TIMESTAMP(?, \'RR-MM-DD HH24:MI:SS\')", [$driver, $datetime]);
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
        $Location = new Location;
        $validLocations = $Location->getValidLocations();
        
        $curr_driver = DB::select('SELECT * FROM Owns_Car c WHERE c.ownerEmail=?', [$driver]);
        $driverride = DB::select("SELECT * FROM Driver_Ride r WHERE r.driveremail=? AND r.departdatetime=TO_TIMESTAMP(?, \'RR-MM-DD HH24:MI:SS\')", [$driver, $datetime]);

        $driverride_details = array(
            'departDateTime' => $newDate = date("d-m-y H:i:s", strtotime($driverride[0]->departdatetime)),
            'departLocation' => $driverride[0]->departlocation,
            'destination' => $driverride[0]->destination,
            'driverEmail' => $driverride[0]->driveremail,
            'pricePerSeat' => $driverride[0]->priceperseat,
            'numSeats' => $driverride[0]->numseats,
            'isCancelled' => $driverride[0]->iscancelled,
            'isStarted' => $driverride[0]->isstarted,
            'isEnded' => $driverride[0]->isended
        );

        return view('driverride.edit', ['maxSeats' => $curr_driver[0]->numseats, 'validLocations' => $validLocations, 'driverrides' => $driverride_details, 'name' => $user[0]->name, 'avatar' => $user[0]->avatar, 'email' => $user[0]->email, 'admin' => $user[0]->isadmin]);
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
        
        $departlocation = $inputs['departLocation'];
        $destination = $inputs['destination'];
        $priceperseat = $inputs['pricePerSeat'];
        $numseats = $inputs['numSeats'];
        $iscancelled = $inputs['isCancelled'];
        $isstarted = $inputs['isStarted'];
        $isended = $inputs['isEnded'];

        DB::update('UPDATE Driver_Ride SET departlocation = ?, destination = ?, priceperseat = ?, numseats = ?, iscancelled = ?, isstarted = ?, isended = ?  WHERE driveremail = ? AND departdatetime = TO_TIMESTAMP(?, \'DD-MM-RR HH24:MI:SS\')', [$departlocation, $destination, $priceperseat, $numseats, $iscancelled, $isstarted, $isended, $driver, $datetime]);
        return Redirect::to('/driverrides/driver/'.$driver.'/datetime/'.date_format(date_create_from_format('d-m-y H:i:s', $datetime), 'Y-m-d H:i:s'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($driver, $datetime)
    {
        DB::delete('DELETE FROM Driver_Ride r WHERE r.driveremail=? AND r.departdatetime=TO_TIMESTAMP(?, \'RR-MM-DD HH24:MI:SS\')', [$driver, $datetime]);
        return Redirect::to('/driverrides');
    }
}
