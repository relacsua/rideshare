<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>RideShare | Share your rides</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Raleway:100,300,600' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/common.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/home.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/sidebar.css') }}">
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                        <img id="icon" src="{{ asset('/img/rideshare.png') }}" />
                        <span id="brand-name">RideShare</span>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <div class="profile-img-container">
                                    <img class="profile-img" src="{{$avatar}}">
                                </div>
                                <span class="profile-name">{{explode(' ', $name)[0]}}</span>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/profile">Profile</a></li>
                                <li><a href="/logout">logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <script type="text/javascript" src="{{ asset('/vendor/jquery/dist/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    </body>
</html>
