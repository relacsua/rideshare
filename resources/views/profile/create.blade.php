<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>RideShare | Share your rides</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Raleway:100,600' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
        <style type="text/css">
            body {
                background-color: #fffad5;
                font-family: 'Raleway';
                font-weight: 100;
            }
            .navbar-brand #icon {
                width: 25px;
                display: inline-block;
            }
            .navbar-brand #brand-name {
                display: inline-block;
                font-family: 'lato';
                color: #000;
                padding-left: 5px;
            }
            .navbar-default {
                background-color: #ffd34e;
                border: 0;
                border-radius: 0;
            }
            form {
                margin-top: 25px;
            }
            .form-header {
                font-size: 20px;
                font-weight: 600;
                border-bottom: 1px solid #DACD2F;
                padding-bottom: 15px;
                margin: 15px 0;
            }
            .form-control {
                border-radius: 0;
            }
            .driver-form {
                display: none;
            }
            .btn.btn-default {
                margin-top: 50px;
                float: right;
            }
            .rideshare-btn, .rideshare-btn:hover {
                background-color: #db9e36;
                border: 0;
                border-radius: 0;
                color: #ffffff;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">
                        <img id="icon" src="{{ asset('/img/rideshare.png') }}" />
                        <span id="brand-name">RideShare</span>
                    </a>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-12">
                    {!! Form::model($user, ['url' => '/profiles']) !!}

                        {{-- Start of Person form --}}

                        <div class="personal-form">

                            <p class="form-header">Personal details</p>

                            <div class="form-group">
                                {!! Form::label('email', 'Email') !!}
                                {!! Form::email('email', null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="radio-inline">
                                {!! Form::radio('gender', 'MALE', null, ['id'=> 'gender-male']) !!}
                                {!! Form::label('gender-male', 'Male') !!}
                            </div>
                            <div class="radio-inline">
                                {!! Form::radio('gender', 'FEMALE', null, ['id' => 'gender-female']) !!}
                                {!! Form::label('gender-female', 'Female') !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('age', 'Age') !!}
                                {!! Form::input('number', 'age', null, ['class' => 'form-control', 'min' => 18]) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('avatar', 'Avatar') !!}
                                {!! Form::input('url', 'avatar', null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('password', 'Password') !!}
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        {{-- End of Person form --}}

                        <div class="profile-form">
                            <p class="form-header">Profile details</p>
                            <div class="form-group">
                                {!! Form::label('id', 'Facebook ID') !!}
                                {!! Form::text('id', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('token', 'Facebook token') !!}
                                {!! Form::textarea('token', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                            </div>
                        </div>
                        
                        {{-- Start of Driver form --}}

                        <div class="checkbox-inline">
                            {!! Form::checkbox('isDriver', 1, false, ['id' => 'isDriver']) !!}
                            {!! Form::label('isDriver', 'Do you also wish to register as a driver ?') !!}
                        </div>
                        
                        <div class="driver-form">

                            <p class="form-header">Driving details</p>

                            <div class="form-group">
                                {!! Form::label('carPlateNo', 'Car Plate Number') !!}
                                {!! Form::text('carPlateNo', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('carModel', 'Car Model') !!}
                                {!! Form::text('carModel', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('licenceNo', 'Licence Number') !!}
                                {!! Form::text('licenceNo', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('numSeats', 'Maximum number of seats (excluding driver seat)') !!}
                                {!! Form::input('number', 'numSeats', null, ['class' => 'form-control', 'min' => 0]) !!}
                            </div>
                        </div>

                        {{-- End of Driver form --}}

                        {!! Form::submit('Sign up', ['class' => 'btn btn-default rideshare-btn']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        
        <!-- scripts below -->
        <script type="text/javascript" src="{{ asset('/vendor/jquery/dist/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript">
            if (window.location.hash && window.location.hash == '#_=_') {
                if (window.history && history.pushState) {
                    window.history.pushState("", document.title, window.location.pathname);
                } else {
                    // Prevent scrolling by storing the page's current scroll offset
                    var scroll = {
                        top: document.body.scrollTop,
                        left: document.body.scrollLeft
                    };
                    window.location.hash = '';
                    // Restore the scroll offset, should be flicker free
                    document.body.scrollTop = scroll.top;
                    document.body.scrollLeft = scroll.left;
                }
            }
        </script>
        <script type="text/javascript">
            
            if($('#isDriver').prop('checked')) {
                $('.driver-form').show();
            } else {
                $('.driver-form').hide();
            }

            $('#isDriver').on('click', function () {
                $('.driver-form').slideToggle();
            })
        </script>
    </body>
</html>
