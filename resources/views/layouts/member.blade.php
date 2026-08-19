<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>@yield('title','KUD.EARN')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('css/member.css') }}" rel="stylesheet">

</head>

<body>

@include('components.sidebar')

<div class="main-content">

    @include('components.topbar')

    <div class="page-content">

        @yield('content')

    </div>

    @include('components.footer')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>

</html>