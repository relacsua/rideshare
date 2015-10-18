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

class UserController extends Controller
{

		 /**
     * Method shows how to query database and render view with data.
     *
     * @return Response
     */
    public function welcome(Request $request)
    {
    		$user = Session::get('email');
    		
    		if($user) {
    			return Redirect::to('/');
    		} else {
    			return view('welcome');
    		}
        
    }

    public function home(Request $request)
    {
    	$user = Session::get('email');
    	
    	if(!$user) {
    		return Redirect::to('/welcome');
    	} else {
    		return view('home');
    	}

    }

    public function redirectToFacebook()
    {
        return Socialize::with('facebook')->scopes(['email'])->redirect();
    }

    public function handleFacebookCallback(Request $request)
    {
        $user = Socialize::with('facebook')->user();
        $user_email = DB::select("SELECT p.email FROM Has_Profile p WHERE p.userID=?", [$user->getId()]);

        if(!$user_email) {
        	Session::put('user', $user);
        	return Redirect::to('/profiles/new');
        } else {
					Session::put('email', $user_email);
					return Redirect::to('/');
        }
    }

    // public function newProfile(Request $request) {
    // 	$user = Session::get('user');
    // 	Session::forget('user');

    // 	$user_details = array(
    // 		'email' => $user->getEmail(),
    // 		'name' => $user->getName(),
    // 		'gender' => strtoupper($user->user['gender']),
    // 		'avatar' => $user->avatar_original,
    // 		'token' => $user->token,
    // 		'id' => $user->id
    // 	);
    	
    // 	return view('profile.create', ['user' => $user_details]);
    // }

   //  public function createProfile(Request $request) {
			
			// $inputs = Request::all();
		 //  $email = $inputs['email'];
		 //  $name = $inputs['name'];
		 //  $age = $inputs['age'];
		 //  $gender = $inputs['gender'];
		 //  $avatar = $inputs['avatar'];
		 //  $password = Hash::make($inputs['password']);
		 //  $token = $inputs['token'];
		 //  $id = $inputs['id'];
		 //  $isDriver = array_key_exists('isDriver', $inputs);
		  
			// DB::insert("INSERT INTO Person (email, name, gender, avatar, age, password) VALUES (?,?,?,,?,?)", [$email, $name, $gender, $avatar, $age, $password]);
			// DB::insert("INSERT INTO Has_Profile (token, userID, email) VALUES (?,?,?)", [$token, $id, $email]);
			
			// if($isDriver) {
			// 	$carPlateNo = $inputs['carPlateNo'];
			// 	$carModel = $inputs['carModel'];
			// 	$licenceNo = $inputs['licenceNo'];
			// 	$numSeats = $inputs['numSeats'];
				
			// 	DB::insert("INSERT INTO Owns_Car (carPlateNo, carModel, ownerLicenseNo, ownerEmail, numSeats) VALUES (?,?,?,?,?)", [$carPlateNo, $carModel, $licenceNo, $email, $numSeats]);
			// }

   //  }

    public function login(Requests\LoginRequest $request) {
    	$email = $request->email;
      $password = $request->password;
      
      try {
          // $user = DB::select('SELECT * FROM PERSON p WHERE p.email=? AND p.password=?', [$email, $password]);
          dd('hello worked');
      } catch (\Illuminate\Database\QueryException $e) {
          return var_dump($e);
      }
    }

    public function logout(Request $request) {
    	Session::forget('email');
    	return Redirect::to('/welcome');
    }
}
