<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use DB;
use Socialize;

class UserController extends Controller
{

		 /**
     * Method shows how to query database and render view with data.
     *
     * @return Response
     */
    public function welcome(Request $request)
    {
    		$user = $request->session()->get('email');
    		
    		if($user) {
    			return Redirect::to('/');
    		} else {
    			return view('welcome');
    		}
        
    }

    public function home(Request $request)
    {
    	$user = $request->session()->get('email');
    	
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
        $user_email = DB::select("SELECT p.email FROM Profile p WHERE p.userID=?", [$user->getId()]);

        if(!$user_email) {
        	DB::insert("INSERT INTO Person (email, name, gender, avatar) VALUES (?,?,?,?)", [$user->getEmail(), $user->getName(), strtoupper($user->user['gender']), $user->avatar_original]);
        	DB::insert("INSERT INTO Profile (token, userID, email) VALUES (?,?,?)", [$user->token, $user->getID(), $user->getEmail()]);
        	$request->session()->put('email', $user->getEmail());
        	return Redirect::to('/profile');
        } else {
					$request->session()->put('email', $user_email);
					return Redirect::to('/');
        }
    }

    public function editProfile(Request $request) {
    	return view('profile.edit', ['email' => $request->session()->get('email')]);
    }

    public function logout(Request $request) {
    	$request->session()->forget('email');
    	return Redirect::to('/welcome');
    }
}
