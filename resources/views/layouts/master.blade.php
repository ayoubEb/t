
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	    <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<title>
    @yield('title')
  </title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->
  <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" />

    <meta name="theme-color" content="#ffffff">
  @include('layouts.vendor-css')
</head>
<body data-sidebar="dark">
	<div class="main-wrapper">

		<!-- partial:partials/_sidebar.html -->
        @include('layouts.topbar')
		<!-- partial -->

		<div class="page-wrapper">

            <!-- partial:partials/_navbar.html -->
            @include('layouts.sidebar')

			<!-- partial -->
            <div class="main-content">
                <div class="page-content">
                    @yield('content')
                </div>
            </div>



		</div>
	</div>
    @include('layouts.vendor-js')

    @yield('script')
</body>
</html>
