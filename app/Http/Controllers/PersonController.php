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

class PersonController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $email = Session::get('email');
        $person = DB::select('SELECT * FROM Person p WHERE p.email=?', [$email]);

        $persons = DB::select('SELECT * FROM Person');
        
        return view('person.index', ['persons' => $persons, 'name' => $person[0]->name, 'avatar' => $person[0]->avatar, 'email' => $person[0]->email, 'admin' => $person[0]->isadmin]);
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
        
        $person = DB::select('SELECT * FROM Person p WHERE p.email=?', [$id]);

        return view('person.show', ['person' => $person, 'name' => $user[0]->name, 'avatar' => $user[0]->avatar, 'email' => $user[0]->email, 'admin' => $user[0]->isadmin]);
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

        $person = DB::select('SELECT * FROM Person p WHERE p.email=?', [$id]);
        
        $user_details = array(
            'email' => $person[0]->email,
            'name' => $person[0]->name,
            'age' => $person[0]->age,
            'gender' => strtoupper($person[0]->gender),
            'avatar' => $person[0]->avatar,
            'balance' => $person[0]->balance,
            'isadmin' => $person[0]->isadmin
        );

        return view('person.edit', ['person' => $user_details, 'name' => $user[0]->name, 'avatar' => $user[0]->avatar, 'email' => $user[0]->email, 'admin' => $user[0]->isadmin]);
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

        $email = $inputs['email'];
        $name = $inputs['name'];
        $age = $inputs['age'];
        $gender = $inputs['gender'];
        $avatar = $inputs['avatar'];
        $balance = $inputs['balance'];
        $isadmin = $inputs['isadmin'];

        DB::update("UPDATE Person set name = ?, age = ?, gender = ?, avatar = ?, balance = ?, isadmin = ?  WHERE email = ?", [$name, $age, $gender, $avatar, $balance, $isadmin, $email]);

        return Redirect::to('/persons/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        DB::delete('DELETE FROM Person p WHERE p.email=?', [$id]);
        return Redirect::to('/persons');
    }
}
