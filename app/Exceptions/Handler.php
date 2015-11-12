<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Redirect;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        } else if ($e instanceof QueryException) {
            preg_match_all('/ORA-20001: constraint (.*?) violated/', $e, $matchTriggerViolations);
            preg_match_all('/ORA-02290: check constraint (.*?) violated/', $e, $matchConstraintViolations);

            if (count($matchTriggerViolations[1])) {
                switch ($matchTriggerViolations[1][0]) {
                    case '(not a driver)':
                        return redirect::back()->with('errors', 'Sorry, you are not a driver.');
                    
                    case '(invalid ride capacity)':
                        return redirect::back()->with('errors', 'Your car does not have enough capacity for your stated ride.');
                    
                    case '(ride timing not after 1 hour of current time)':
                        return redirect::back()->with('errors', 'Your departure timing must be at least 1 hour after the current time.');
                    
                    case '(ride to insert too close to others)':
                        return redirect::back()->with('errors', 'You have other rides that are too close to this ride (i.e. within +/- 1 hour of your other rides).');
                    
                    case '(not enough credit)':
                        return redirect::back()->with('errors', 'You do not have enough credit in your account balance for this ride.');
                    
                    case '(ride to sign up too close to others)':
                        return redirect::back()->with('errors', 'You have signed up for rides that are too close to the selected ride (i.e. within +/- 1 hour of your other rides).');
                }
            }

            if (count($matchConstraintViolations[1])) {
                switch ($matchConstraintViolations[1][0]) {
                    case '(A0097663.VALIDBALANCE)':
                        return redirect::back()->with('errors', 'Your account balance cannot be negative.');
                    
                    case '(A0097663.VALIDEMAIL)':
                        return redirect::back()->with('errors', 'Your email is invalid.');
                    
                    case '(A0097663.VALIDNUMSEATS)':
                        return redirect::back()->with('errors', 'Your car must have at least 1 seating capacity.');
                    
                    case '(A0097663.VALIDCANCEL)':
                        return redirect::back()->with('errors', 'You cannot cancel the ride after it has started.');
                    
                    case '(A0097663.VALIDPRICE)':
                        return redirect::back()->with('errors', 'Your ride price-per-seat cannot be negative.');
                    
                    case '(A0097663.VALIDDESTANDDEPARTLOC)':
                        return redirect::back()->with('errors', 'Your destination cannot be the same as your departure location!');
                    
                    case '(A0097663.NOOWNRIDESIGNUP)':
                        return redirect::back()->with('errors', 'You cannot sign up for your own ride.');
                }
            }
        }

        return parent::render($request, $e);
    }
}
