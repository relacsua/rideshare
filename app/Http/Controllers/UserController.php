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
        $faculty = DB::select('SELECT s.name FROM student s WHERE s.department=? AND ROWNUM=1', [$name]);
        return view('welcome', ['faculty' => $faculty[0]->name]);
    }

}
