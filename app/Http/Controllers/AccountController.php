<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use DB;
use Request;
use Hash;
use Session;

class AccountController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
			// user object is stored in the session when
	    // an user logs in using facebook
	    
	    $user = Session::get('user');
	    Session::forget('user');

	    $user_details = array(
	        'email' => $user->getEmail(),
	        'name' => $user->getName(),
	        'gender' => strtoupper($user->user['gender']),
	        'avatar' => $user->avatar_original,
	        'token' => $user->token,
	        'id' => $user->id
	    );
	    
	    return view('account.create', ['user' => $user_details]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store()
    {
			$inputs = Request::all();
      $email = $inputs['email'];
      $name = $inputs['name'];
      $age = $inputs['age'];
      $gender = $inputs['gender'];
      $avatar = $inputs['avatar'];
      $password = Hash::make($inputs['password']);
      $token = $inputs['token'];
      $id = $inputs['id'];
      $isDriver = array_key_exists('isDriver', $inputs);
      
        DB::insert("INSERT INTO Person (email, name, gender, avatar, age, password) VALUES (?,?,?,?,?,?)", [$email, $name, $gender, $avatar, $age, $password]);
        DB::insert("INSERT INTO Has_Profile (token, userID, email) VALUES (?,?,?)", [$token, $id, $email]);
        
        if($isDriver) {
            $carPlateNo = $inputs['carPlateNo'];
            $carModel = $inputs['carModel'];
            $licenceNo = $inputs['licenceNo'];
            $numSeats = $inputs['numSeats'];
            
            DB::insert("INSERT INTO Owns_Car (carPlateNo, carModel, ownerLicenseNo, ownerEmail, numSeats) VALUES (?,?,?,?,?)", [$carPlateNo, $carModel, $licenceNo, $email, $numSeats]);
        }

        return Redirect::to('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show()
    {
			$email = Session::get('email');

      $person = DB::select('SELECT * FROM Person p WHERE p.email=?', [$email]);
      $car = DB::select('SELECT * FROM Owns_Car c WHERE c.ownerEmail=?', [$email]);
      $profile = DB::select('SELECT * FROM Has_Profile p WHERE p.email=?', [$email]);

      return view('account.show', ['person' => $person, 'car' => $car, 'profile' => $profile, 'name' => $person[0]->name, 'avatar' => $person[0]->avatar, 'email' => $person[0]->email, 'admin' => $person[0]->isadmin]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit()
    {
   		$email = Session::get('email');

    	$person = DB::select('SELECT * FROM Person p WHERE p.email=?', [$email]);
    	$car = DB::select('SELECT * FROM Owns_Car c WHERE c.ownerEmail=?', [$email]);
    	$profile = DB::select('SELECT * FROM Has_Profile p WHERE p.email=?', [$email]);

    	$user_details = array(
	    	'email' => $person[0]->email,
	      'name' => $person[0]->name,
	      'age' => $person[0]->age,
	      'gender' => strtoupper($person[0]->gender),
	      'avatar' => $person[0]->avatar,
	      'token' => $profile[0]->token,
	      'id' => $profile[0]->userid
	    );

	    if(!empty($car)) {
	    	$user_details['carPlateNo'] = $car[0]->carplateno;
	    	$user_details['carModel'] = $car[0]->carmodel;
	    	$user_details['licenceNo'] = $car[0]->ownerlicenseno;
	    	$user_details['numSeats'] = $car[0]->numseats;
	    }

    	return view('account.edit', ['user' => $user_details, 'name' => $person[0]->name, 'avatar' => $person[0]->avatar, 'email' => $person[0]->email, 'admin' => $person[0]->isadmin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update()
    {
			$inputs = Request::all();
      $email = Session::get('email');
      $name = $inputs['name'];
      $age = $inputs['age'];
      $gender = $inputs['gender'];
      $avatar = $inputs['avatar'];
      $oldPassword = $inputs['oldPassword'];
      $newPassword = $inputs['newPassword'];
      $isDriver = array_key_exists('isDriver', $inputs);
     
      if (!empty($oldPassword) && !empty($newPassword)) {
      	$user = DB::select('SELECT p.password FROM PERSON p WHERE p.email=?', [$email]);
      	$hashed_password = $user[0]->password;
				
				if(Hash::check($oldPassword, $hashed_password)) {
					$password = Hash::make($newPassword);
					DB::update("UPDATE Person set name = ?, gender = ?, avatar = ?, age = ?, password = ? WHERE email = ?", [$name, $gender, $avatar, $age, $password, $email]);
				} else {
					return Redirect::to('/me/edit')->with('errors', array('Old password field is set incorrectly.'));
				}
      } else if (empty($oldPassword) && empty($newPassword)) {
      	DB::update("UPDATE Person set name = ?, gender = ?, avatar = ?, age = ? WHERE email = ?", [$name, $gender, $avatar, $age, $email]);
      } else {
      	return Redirect::to('/me/edit')->with('errors', array('Bold password fields must be set to update password.'));
      }
      
      $car = DB::select('SELECT * FROM Owns_Car c WHERE c.ownerEmail=?', [$email]);
      
      if($isDriver) {
      	
      	$carPlateNo = $inputs['carPlateNo'];
        $carModel = $inputs['carModel'];
        $licenceNo = $inputs['licenceNo'];
        $numSeats = $inputs['numSeats'];
				
				if(empty($car)) {
      		DB::insert("INSERT INTO Owns_Car (carPlateNo, carModel, ownerLicenseNo, ownerEmail, numSeats) VALUES (?,?,?,?,?)", [$carPlateNo, $carModel, $licenceNo, $email, $numSeats]);
      	} else{
          DB::update("UPDATE Owns_Car set carPlateNo = ?, carModel = ?, ownerLicenseNo = ?, numSeats = ? WHERE ownerEmail = ?", [$carPlateNo, $carModel, $licenceNo, $numSeats, $email]);
      	}
      } else {
      	if(!empty($car)) {
      		 DB::delete('delete from Owns_Car where ownerEmail = ?', [$email]);
      	}
      }

      return Redirect::to('/me');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
