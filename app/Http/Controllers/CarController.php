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

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $email = Session::get('email');

        $cars = DB::select('SELECT * FROM Owns_Car');
        $person = DB::select('SELECT * FROM Person p WHERE p.email=?', [$email]);
        
        return view('car.index', ['cars' => $cars, 'name' => $person[0]->name, 'avatar' => $person[0]->avatar, 'email' => $person[0]->email, 'admin' => $person[0]->isadmin]);
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
    public function show($id)
    {
        $email = Session::get('email');
        $user = DB::select('SELECT * FROM Person p WHERE p.email=?', [$email]);
        
        $car = DB::select('SELECT * FROM Owns_Car c WHERE c.owneremail=? AND c.carplateno=?', [$email, $id]);

        return view('car.show', ['car' => $car, 'name' => $user[0]->name, 'avatar' => $user[0]->avatar, 'email' => $user[0]->email, 'admin' => $user[0]->isadmin]);
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

        $car = DB::select('SELECT * FROM Owns_Car c WHERE c.carplateno=?', [$email, $id]);
        
        $car_details = array(
            'carplateno' => $car[0]->carplateno,
            'carmodel' => $car[0]->carmodel,
            'ownerlicenseno' => $car[0]->ownerlicenseno,
            'numseats' => $car[0]->numseats
        );

        return view('car.edit', ['car' => $car_details, 'name' => $user[0]->name, 'avatar' => $user[0]->avatar, 'email' => $user[0]->email, 'admin' => $user[0]->isadmin]);
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

        $carplateno = $inputs['carplateno'];
        $carmodel = $inputs['carmodel'];
        $ownerlicenseno = $inputs['ownerlicenseno'];
        $numseats = $inputs['numseats'];
        $owneremail = Session::get('email');

        DB::update("UPDATE Owns_Car set carplateno = ?, carmodel = ?, ownerlicenseno = ?, numseats = ? WHERE owneremail = ?", [$carplateno, $carmodel, $ownerlicenseno, $numseats, $owneremail]);

        return Redirect::to('/cars/'.$carplateno);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        DB::delete('DELETE FROM Owns_Car c WHERE c.carplateno=?', [$id]);
        return Redirect::to('/cars');
    }
}
