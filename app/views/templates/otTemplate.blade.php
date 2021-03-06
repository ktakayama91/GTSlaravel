<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
    <meta name="robots" content="noindex, follow">
    <title>Ordenes de Trabajo</title>
    <link rel="shortcut icon" href="{{ asset('img')}}/logo_gts.png">
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Datepicker CSS-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
    <!-- Calendar CSS-->
    <link rel="stylesheet" href="{{ asset('css/responsive-calendar.css') }}">
    <!-- MetisMenu CSS -->
    <link href="{{ asset('bower_components/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">
    <!-- Timeline CSS -->
    <link href="{{ asset('dist/css/timeline.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="{{ asset('bower_components/morrisjs/morris.css') }}" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <script type="text/javascript">
        var inside_url = "{{$inside_url}}";
    </script>

    <!-- jQuery -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Moment JavaScript -->
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <!-- Bootstrap Datepicker JavaScript -->
    <script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- Bootstrap Calendar JavaScript -->
    <script type="text/javascript" src="{{ asset('js/responsive-calendar.min.js') }}"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('bower_components/metisMenu/dist/metisMenu.min.js') }}"></script>
    <!-- Morris Charts JavaScript -->
    <script src="{{ asset('bower_components/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('bower_components/morrisjs/morris.min.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('dist/js/sb-admin-2.js') }}"></script>
    <script src="{{ asset('js/bienes/reportes_incumplimiento.js') }}"></script>
    <script src="{{ asset('js/bienes/ot.js') }}"></script>
    <script src="{{ asset('js/bienes/listOtPreventivo.js')}}"></script>
    <script src="{{ asset('js/bienes/addOtPreventivo.js')}}"></script>

</head>

<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		@include('layouts.header', array('user'=>$user))
        @include('layouts.sidebar', array('user'=>$user))		
        <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        	@yield('content')
        </div>
	</div>
</body>
</html>