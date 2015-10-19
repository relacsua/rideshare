<?php

namespace App\Http\Middleware;

use Closure;

use DB;
use Session;
use Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $email = Session::get('email');
        $user = DB::select('SELECT p.isAdmin FROM PERSON p WHERE p.email=?', [$email]);
        
        if($user[0]->isadmin == 'FALSE')
            abort(404);
        else
            return $next($request);
    }
}
