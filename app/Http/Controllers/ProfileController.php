<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Redirect;

use DB;
use Session;
use Request;
use Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $email = Session::get('email');
        $user = DB::select('SELECT * FROM Person p WHERE p.email=?', [$email]);
        
        $profiles = DB::select('SELECT * FROM has_profile');

        return view('profile.index', ['profiles' => $profiles, 'name' => $user[0]->name, 'avatar' => $user[0]->avatar, 'email' => $user[0]->email, 'admin' => $user[0]->isadmin]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $email = Session::get('email');
        $user = DB::select('SELECT * FROM Person p WHERE p.email=?', [$email]);
        
        $profile = DB::select('SELECT * FROM has_profile p WHERE p.email=?', [$id]);

        return view('profile.show', ['profile' => $profile, 'name' => $user[0]->name, 'avatar' => $user[0]->avatar, 'email' => $user[0]->email, 'admin' => $user[0]->isadmin]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $email = Session::get('email');
        $user = DB::select('SELECT * FROM Person p WHERE p.email=?', [$email]);

        $profile = DB::select('SELECT * FROM has_profile p WHERE p.email=?', [$id]);
        
        $profile_details = array(
            'email' => $profile[0]->email,
            'userid' => $profile[0]->userid,
            'token' => $profile[0]->token,
        );

        return view('profile.edit', ['profile' => $profile_details, 'name' => $user[0]->name, 'avatar' => $user[0]->avatar, 'email' => $user[0]->email, 'admin' => $user[0]->isadmin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $inputs = Request::all();

        $userid = $inputs['userid'];
        $token = $inputs['token'];

        DB::update("UPDATE has_profile set token = ? WHERE email = ? AND  userid = ?", [$token, $id, $userid]);

        return Redirect::to('/profiles/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($email, $id)
    {
        DB::delete('DELETE FROM has_profile p WHERE p.email=? AND p.userid=?', [$email, $id]);
        return Redirect::to('/persons');
    }
}
