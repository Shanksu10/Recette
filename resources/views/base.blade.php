<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

        <title> {{ config('app.name') }} - @yield('title') </title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/app.css') }}">
        <link href='https://fonts.googleapis.com/css?family=Italianno' rel='stylesheet'>

    </head>
    <body style="
        margin-top:100px;
    ">
         {{-- bar de navigation  --}}
         @include('navbar/navbar')

         {{-- contenu de chaque page  --}}

         @yield('content')


         <!-- nos script -->
         @include('script')
    </body>
</html>
