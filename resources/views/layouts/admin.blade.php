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
	<link rel="stylesheet" href="{{ asset('admin/assets/vendors/typicons/typicons.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">
	<!-- endinject -->
	<!-- Plugin css for this page -->
	<!-- <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
	<link rel="stylesheet" href="js/select.dataTables.min.css"> -->
	<!-- End plugin css for this page -->
	<!-- inject:css -->
	<link rel="stylesheet" href="{{ asset('admin/assets/css/vertical-layout-light/style.css') }}">
	<!-- endinject -->
	<link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
	
	<div class="container-scroller">
		@include('includes.admin.header')
		<div class="container-fluid page-body-wrapper">
			@include('includes.admin.sidebar')
			<div class="main-panel">
				@yield('content')
				@include('includes.admin.footer')
