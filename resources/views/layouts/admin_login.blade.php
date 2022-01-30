<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" style="width: auto;height: auto;">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Noodle', 'Noodle (lbaw2152)') }}</title>

    <!-- Styles -->
    <link rel="icon" type="image/png" sizes="717x722" href="{{ asset('assets/img/mascot.png') }}">
    <link rel="icon" type="image/png" sizes="717x722" href="{{ asset('assets/img/mascot.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('assets/fonts/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footer-yellow.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header-yellow.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Login-Form-Clean.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Login-Form-Dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Navigation-with-Button.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    <script type="text/javascript" src={{ asset('js/app.js') }} defer></script>

  </head>
  <body>
      @include('headers.navBarAdmin')
      <section id="content">
        @yield('content')
      </section>

      @include('partials.footer')
      @include('layouts.scripts')
      
  </body>
</html>
