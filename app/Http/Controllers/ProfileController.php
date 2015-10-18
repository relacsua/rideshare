<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        
        return view('profile.create', ['user' => $user_details]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
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
        //
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
