<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

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
        $faculty = DB::select("SELECT s.faculty FROM student s WHERE s.name=? AND ROWNUM=1", [$name]);
        return view('welcome', ['faculty' => $faculty[0]->faculty]);
    }

}
