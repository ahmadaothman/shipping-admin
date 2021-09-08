	<!-- Basic Page Info -->
	<meta charset="utf-8">

	<!-- Site favicon -->
	<!-- <link rel="shortcut icon" href="images/favicon.ico"> -->

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	 <!-- CSRF Token -->
	 <meta name="csrf-token" content="{{ csrf_token() }}">

	 <title>{{ config('app.name', 'Laravel') }}</title>
	 
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" href="{{ asset('vendors/styles/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/src/plugins/jvectormap/jquery-jvectormap-2.0.3.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ asset('/src/plugins/datatables/media/css/jquery.dataTables.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/src/plugins/datatables/media/css/dataTables.bootstrap4.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/src/plugins/datatables/media/css/responsive.dataTables.css') }}">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script src="{{ asset('/vendors/scripts/script.js') }}"></script>

	<script src="{{ asset('/src/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('/src/plugins/sweetalert2/sweetalert2.css') }}">
	<script src="{{ asset('/src/plugins/sweetalert2/sweet-alert.init.js') }}"></script>

	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-119386393-1');
	</script>
