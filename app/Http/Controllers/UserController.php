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
    	$email = Session::get('email');

    	if(!$email) {
    		return Redirect::to('/welcome');
    	} else {
    		$user = DB::select('SELECT * FROM PERSON p WHERE p.email=?', [$email]);
    		$user_info = array('name' => $user[0]->name, 'avatar' => $user[0]->avatar, 'email' => $user[0]->email);
    		return view('dashboard', $user_info);
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
        	return Redirect::to('/signup');
        } else {
					Session::put('email', $user_email);
					return Redirect::to('/');
        }
    }

    public function login(Requests\LoginRequest $request) {
    	$email = $request->email;
      $password = $request->password;
      
      try {
          $user = DB::select('SELECT p.password FROM PERSON p WHERE p.email=?', [$email]);
          
          if(empty($user)) {
          	$errors = array('Invalid email address/password');
          	return Redirect::to('/welcome')->with('errors', $errors);
          } else {
						$hashed_password = $user[0]->password;
						if(Hash::check($password, $hashed_password)) {
							Session::put('email', $email);
							return Redirect::to('/');
							} else {
							return Redirect::to('/welcome')->with('error', 'Invalid email address/password');
							}
          }

      } catch (\Illuminate\Database\QueryException $e) {
          return var_dump($e);
      }
    }

    public function logout(Request $request) {
    	Session::forget('email');
    	return Redirect::to('/welcome');
    }

    public function create() {
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
        
        return view('profile.create', ['user' => $user_details]);
    }

    public function store(Request $request)
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

    public function show()
    {
    		$email = Session::get('email');

        $person = DB::select('SELECT * FROM Person p WHERE p.email=?', [$email]);
        $car = DB::select('SELECT * FROM Owns_Car c WHERE c.ownerEmail=?', [$email]);
        $profile = DB::select('SELECT * FROM Has_Profile p WHERE p.email=?', [$email]);

        return view('profile', ['person' => $person, 'car' => $car, 'profile' => $profile, 'name' => $person[0]->name, 'avatar' => $person[0]->avatar, 'email' => $person[0]->email]);
    }
}
