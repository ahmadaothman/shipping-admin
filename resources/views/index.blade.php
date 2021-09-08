<!DOCTYPE html>
<html>
<head>
	@include('layouts.head')
</head>

<body>
	@include('layouts.header')
	<x-layouts.leftsidebar ></x-layouts.leftsidebar>

	<div class="main-container">
		@yield('content')
	</div>

</body>
</html>