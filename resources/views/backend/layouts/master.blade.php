<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dashboard') }}- </title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    @include('backend.include.styles')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">


@include('backend.include.header')

@include('backend.include.sidebar')

<!-- Content Wrapper. Contains page content -->

@yield('content')

<!-- /.content-wrapper -->

    @include('backend.include.footer')

    @include('backend.include.control-sidebar')
</div>
<!-- ./wrapper -->

@include('backend.include.scripts')
@yield('script')
</body>

</html>
