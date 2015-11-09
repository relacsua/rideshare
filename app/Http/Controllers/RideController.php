<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Library\Location;

use DB;
use Session;
use Request;

class RideController extends Controller
{
    public function create()
    {
		$email = Session::get('email');
		$user = DB::select('SELECT * FROM Person p where p.email=?', [$email]);
		$driver = DB::select('SELECT * FROM Owns_Car c where c.ownerEmail=?', [$email]);

		if(empty($driver)) {
			return Redirect::to('/')->with('errors', array('You ain\'t a driver, mate.'));
		} else {
			$Location = new Location;
			$validLocations = $Location->getValidLocations();
			$ride = array();
			return view('rides.new', array('ride' => $ride, 'maxSeats' => $driver[0]->numseats, 'validLocations' => $validLocations, 'name' => $user[0]->name, 'avatar' => $user[0]->avatar, 'email' => $user[0]->email, 'admin' => $user[0]->isadmin));
		}
    }

    public function store(Request $request)
    {		
    	$email = Session::get('email');
    	$driver = DB::select('SELECT * FROM Owns_Car c where c.ownerEmail=?', [$email]);
    		
    	if(empty($driver)) {
			return Redirect::to('/')->with('errors', array('You ain\'t a driver, mate.'));
		} else {
			$inputs = Request::all();
	        $departLocation = $inputs['departLocation'];
	        $destination = $inputs['destination'];
	        $departDateTime = $inputs['departDateTime'];
	        $pricePerSeat = $inputs['pricePerSeat'];
	        $numSeats = $inputs['numSeats'];
	        DB::insert("INSERT INTO Driver_Ride (departLocation, destination, departDateTime, pricePerSeat, numSeats, driverEmail) VALUES (?,?,to_timestamp(?, 'dd-mm-rr hh24:mi:ss'),?,?,?)", [$departLocation, $destination, $departDateTime, $pricePerSeat, $numSeats, $email]);
	        
	        return Redirect::to('/');
		}
    }

    public function search(request $request)
    {
    	$email = Session::get('email');
		$user = DB::select('SELECT * FROM Person p where p.email=?', [$email]);
    	$Location = new Location;
		$validLocations = $Location->getValidLocations();
		$inputs = Request::all();
		$results = array();
		
		if(!empty($inputs)) {
			$departLocation = $inputs['departLocation'];
			$destination = $inputs['destination'];
			$departDateTimeStart = $inputs['departDateTimeStart'];
			$departDateTimeEnd = $inputs['departDateTimeEnd'];
			$maxPricePerSeat = $inputs['maxPricePerSeat'];
			$query = "SELECT "
			."p.name, p.age, p.avatar, p.gender, c.carModel, r.departLocation, r.destination, r.departDateTime, r.numSeats,r.pricePerSeat, numPassenger "
			."FROM Driver_Ride r "
			."INNER JOIN Person p "
			."ON r.driverEmail=p.email "
			."INNER JOIN Owns_car c "
			."ON r.driverEmail=c.owneremail "
			."LEFT JOIN "
			."( "
				."SELECT pr.RIDEDRIVEREMAIL as pr_rider,pr.RIDEDEPARTDATETIME as pr_date, COUNT(*) as numPassenger "
				."FROM Passenger pr "
				."GROUP BY pr.RIDEDRIVEREMAIL,pr.RIDEDEPARTDATETIME "
			.") "
			."ON r.driverEmail = pr_rider AND r.departDateTime = pr_date "
			."WHERE r.departDateTime >= to_timestamp(?, 'dd-mm-rr hh24:mi:ss') "
			."AND r.departDateTime <= to_timestamp(?, 'dd-mm-rr hh24:mi:ss') "
			."AND r.isCancelled = 'FALSE' AND r.isEnded = 'FALSE' AND r.isStarted = 'FALSE' "
			."AND r.pricePerSeat <= ? "
			."AND r.departLocation= ? "
			."AND r.destination= ? "
			."AND r.driverEmail<> ? "
			."AND (numPassenger < r.numSeats OR numPassenger is null)";

			$results = DB::select($query, [$departDateTimeStart, $departDateTimeEnd, $maxPricePerSeat, $departLocation, $destination, 'dummy@email.com']);
		}
	
    	return view('rides.search', array('ride' => $inputs, 'results' => $results, 'validLocations' => $validLocations, 'name' => $user[0]->name, 'avatar' => $user[0]->avatar, 'email' => $user[0]->email, 'admin' => $user[0]->isadmin));
    }
}
