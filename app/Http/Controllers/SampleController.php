<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Debugbar; 
use Hash;
use Socialize;

class SampleController extends Controller
{
    /**
     * Method shows how to query database and render view with data.
     *
     * @return Response
     */
    public function index($name)
    {
        // dd (DB::connection()->getPdo());
        $faculty = DB::select("SELECT s.faculty FROM student s WHERE s.name=upper(?) AND ROWNUM=1", [$name]);
        Debugbar::info($faculty);
        // Debugbar::error('Error!');
        // Debugbar::warning('Watch out…');
        // Debugbar::addMessage('Another message', 'mylabel');
        if(empty($faculty))
            return view('sample', ['faculty' => 'Not found']);
        else
            return view('sample', ['faculty' => $faculty[0]->faculty]);
    }

    public function sample()
    {

        return view('extend');
    }

    public function store(Requests\CreateUserRequest $request)
    {
        // $input = Request::all();
        // $input['last_login_at'] = Carbon::now();
        // $email = Request::get('email');
        // $password = Request::get('password');

        $email = $request->email;
        $password = $request->password;
        
        try {
            DB::insert('insert into liverpool (email, password) values (?, ?)', array($email, $password));
        } catch (\Illuminate\Database\QueryException $e) {
            return var_dump($e);
        }
        // $faculty = DB::select("SELECT s.faculty FROM student s WHERE s.name=upper(?) AND ROWNUM=1", [$name]);
        return $request->email;
    }

}