<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>RideShare | Share your rides</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Raleway:100,600' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/welcome.css') }}">
    </head>
    <body>
        
        @if (is_object($errors) && $errors->any())
            @include('errors._alertbar', ['errors' => $errors->all()])
        @elseif (is_array($errors) && count($errors) > 0)
            @include('errors._alertbar', ['errors' => $errors])
        @endif

        <div class="container">
            <div class="content">
                <img class='icon' src="{{ asset('/img/rideshare.png') }}" />
                <h1>RideShare</h2>
                <p class="slogan">Share your rides &middot; Save some cash &middot; Make new friends</p>
                <div class="form-wrapper">
                    {!! Form::open(['url' => '/login']) !!}
                        {!! Form::email('email', null, ['placeholder' => 'email']) !!}
                        {!! Form::password('password', ['placeholder' => 'password']) !!}
                        {!! Form::submit('login') !!}
                    {!! Form::close() !!}
                    <hr />
                    <a href='/login/facebook' class='fb-btn'>Register via facebook</a>
                </div>
            </div>
        </div>
    </body>
</html>
