<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    {{-- <link rel="shortcut icon" href="{{mix('images/favicon.ico') }}"> --}}
    <script type="text/javascript" src="https://vk.com/js/api/share.js?93"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-126618538-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-126618538-1');
    </script>
    <title></title>
</head>

<body>
    <div id="app">
        {{--      @if(!in_array(\Request::route()->getName(),['venue_home','venues_admin','test']))
        <venue-reg-modal></venue-reg-modal>
        @endif --}}
        @yield('header')
        @yield('main')
        @yield('footer')
    </div>
</body>

<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>

</html>
