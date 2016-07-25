<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Laman Utama</title>

    <!-- Bootstrap -->
    <link href="{{ URL::asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('css/style.css')}}" rel="stylesheet">
    {{--<link href="css/bootstrap.min.css" rel="stylesheet">--}}
    {{--<link href="css/style.css" rel="stylesheet">--}}


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <![endif]-->
</head>
<body>
<nav class="navbar navbar-inverse navbar-default navbar-fixed-top" >
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <span class="glyphicon glyphicon glyphicon-home" aria-hidden="true"></span>
                Aduan ICT
            </a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="{{route('complain.create')}}">Tambah Aduan</a>
                    </li>
                    <li class="active">
                        <a href="{{url('complain')}}">
                            Senarai Aduan
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Firdaus Abdul Aziz @ Ahmad
                            <span class="caret">
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="profile">Profile</a></li>
                            <li><a href="katalaluan">Kata Laluan</a></li>
                            <li><a href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
        </div>

    </div><!-- /.container-fluid -->
</nav>
<div class="container">

    @yield('content')

</div>

    @yield('modal')

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ URL::asset('js/bootstrap.min.js')}}"></script>
{{--<script src="js/bootstrap.min.js"></script>--}}
</body>
</html>