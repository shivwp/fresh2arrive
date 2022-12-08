<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>
	
	<!-- plugins:css -->
	<link rel="stylesheet" href="{{ asset('admin/assets/vendors/feather/feather.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/vendors/ti-icons/css/themify-icons.css') }}">
	<!-- <link rel="stylesheet" href="{{ asset('admin/assets/vendors/typicons/typicons.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/vendors/simple-line-icons/css/simple-line-icons.css') }}"> -->
	<link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">
	<!-- endinject -->
	<!-- Plugin css for this page -->
	<!-- <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
	<link rel="stylesheet" href="js/select.dataTables.min.css"> -->
	<!-- End plugin css for this page -->
	<!-- inject:css -->
	<link rel="stylesheet" href="{{ asset('admin/assets/css/vertical-layout-light/style.css') }}">
	<!-- endinject -->
	<!-- Custom Css Start -->
	<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
	<!-- Custom Css End -->

	<link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
	
	<div class="container-scroller">
		@include('includes.admin.header')
		<div class="container-fluid page-body-wrapper">
			@include('includes.admin.sidebar')
			<div class="main-panel master-pages">
				
				@yield('content')

				<footer class="footer">
					<div class="d-sm-flex justify-content-center justify-content-sm-between">
					<!-- <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash.</span> -->
					<span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2021. All rights reserved.</span>
					</div>
				</footer>
			</div>
			<!-- main-panel ends -->
		</div>
		<!-- page-body-wrapper ends -->
	</div>
	<!-- container-scroller -->


<!-- plugins:js -->
<script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<!-- <script src="{{ asset('admin/assets/vendors/chart.js/Chart.min.js') }}"></script> -->
<script src="{{ asset('admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<!-- <script src="{{ asset('admin/assets/vendors/progressbar.js/progressbar.min.js') }}"></script> -->

<!-- End plugin js for this page -->
<!-- inject:js -->
<!-- <script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script> -->
<!-- <script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script> -->
<script src="{{ asset('admin/assets/js/template.js') }}"></script>
<!-- <script src="{{ asset('admin/assets/js/settings.js') }}"></script> -->
<!-- <script src="{{ asset('admin/assets/js/todolist.js') }}"></script> -->
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{ asset('admin/assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
<!-- <script src="{{ asset('admin/assets/js/dashboard.js') }}"></script> -->
<!-- <script src="{{ asset('admin/assets/js/Chart.roundedBarCharts.js') }}"></script> -->
<!-- End custom js for this page-->
<!-- Custom js Start -->
<script src="{{ asset('js/custom.js') }}"></script>
<!-- Custom js End -->

</body>

</html>