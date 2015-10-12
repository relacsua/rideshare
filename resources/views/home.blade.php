<!DOCTYPE html>
<html>
    <head>
        <title>RideShare</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
                background-image: url('/img/sgbg.jpg');
                background-repeat: no-repeat;
                background-size: cover;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">{{$appname}}</div>
                <div class="title">A {{$module}} project</div>
            </div>
        </div>
    <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
    </body>
</html>
