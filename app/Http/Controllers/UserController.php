<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Socialize;

class UserController extends Controller
{

		 /**
     * Method shows how to query database and render view with data.
     *
     * @return Response
     */
    public function welcome()
    {
        return view('welcome');
    }

    public function redirectToFacebook()
    {
        return Socialize::with('facebook')->scopes(['email'])->redirect();
    }

    public function handleFacebookCallback()
    {
        $user = Socialize::with('facebook')->user();

        $data = array(
        	'id'			=> $user->getId(),
        	'name'		=> $user->getName(),
        	'email'		=> $user->getEmail(),
        	'image'		=> $user->avatar_original,
        	'gender'	=> $user->user['gender'],
        	'token'		=> $user->token
        );
        // $user_profile = DB::select("SELECT p.email FROM Profile p WHERE p.userID=?", [$user->getId()]);

        // if(!$user_profile) {
        // 	DB::insert("INSERT INTO Profile (token, userID, email) values ($user->)")
        // } else {

        // }

        dd($data);

        // 1) check if facebook id already exist in the Profile table
        // 	a) if exist, update token in Profile table
        //	b) fetch User via Profile
        //	c) login user & store info in session
        // 2) if id doesnt exist,
        //	a) store data in both Profile and User table
        //	b) store user data in a session
        //	c) redirect to a create profile page

        // $user->getId();
        // $user->getNickname();
        // $user->getName();
        // $user->getEmail();
        // $user->getAvatar();
    }
}
