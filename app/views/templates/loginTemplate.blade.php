<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex, follow">
	<title>Home</title>
	<!-- Styles -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/login/login-style.css') }}">
	<!-- Scripts -->
</head>

<body>
	<div id="main-container">
		@yield('content')
	</div>
</body>
</html>