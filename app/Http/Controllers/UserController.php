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
    		$user_info = array('name' => $user[0]->name, 'avatar' => $user[0]->avatar);
    		return view('home', $user_info);
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
}
