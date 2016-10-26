<!DOCTYPE html>
<html>
<head>
	<title>花蓮好書室 - @yield('title')</title>
	@include('partials.head')
</head>
<body>
	@include('partials.nav')
	@section('content')
	@show
</body>
@include('partials.footer')
</html>