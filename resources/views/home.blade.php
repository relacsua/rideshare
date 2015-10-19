<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>RideShare | Share your rides</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Raleway:100,300,500,600,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/home.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/sidebar.css') }}">
    </head>
    <body>
        @if (is_object($errors) && $errors->any())
            @include('errors._alertbar', ['errors' => $errors->all()])
        @elseif (is_array($errors) && count($errors) > 0)
            @include('errors._alertbar', ['errors' => $errors])
        @endif
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" id="menu-toggle" href="#">
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
                                <li><a href="/logout">logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="navbar-brand">
                <img id="icon" src="{{ asset('/img/rideshare.png') }}" />
                <span id="brand-name">RideShare</span>
            </div>
            <ul class="sidebar-nav">
                <li>
                    <span class="sub-menu-title">Personal</span>
                </li>
                <li class="{{ Request::is( '/') ? 'active' : '' }}">
                    <a href="/">Dashboard</a>
                </li>
                <li class="{{ Request::segment(1) == 'me' ? 'active' : '' }}">
                    <a href="/me">Profile</a>
                </li>
                @if ($admin == 'TRUE')
                <li>
                    <span class="sub-menu-title">Admin</span>
                </li>
                <li class="{{ Request::segment(1) == 'persons' ? 'active' : '' }}">
                    <a href="/profiles">Persons</a>
                </li>
                <li class="{{ Request::segment(1) == 'profiles' ? 'active' : '' }}">
                    <a href="/persons">Profiles</a>
                </li>
                <li class="{{ Request::segment(1) == 'cars' ? 'active' : '' }}">
                    <a href="/cars">Cars</a>
                </li>
                @endif
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <script type="text/javascript" src="{{ asset('/vendor/jquery/dist/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript">
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });
        </script>
    </body>
</html>
