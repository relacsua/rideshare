<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Debugbar;

class UserController extends Controller
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
            return view('welcome', ['faculty' => 'Not Found']);
        else
            return view('welcome', ['faculty' => $faculty[0]->faculty]);
    }

}