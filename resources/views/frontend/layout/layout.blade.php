<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>@yield('title')</title>
        {{-- <link rel="shortcut icon" type="image/x-icon" href="{{url('public/uploads/Config')}}/{{$logo_title->value}}"> --}}
        @include('frontend.layout.css')
    </head>
    <body id="page-top">
        <!-- Start Header -->
        @include('frontend.layout.header')
        <!-- End Header -->
        <!-- Start Main -->
        @yield('content')
        <!-- End Main -->
        <!-- Start Footer -->
        @include('frontend.layout.footer')
        <!-- End Footer -->
        <!-- Back-To-Top -->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
            </a>
        @include('frontend.layout.js')
    </body>
</html>
