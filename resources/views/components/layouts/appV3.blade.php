<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/ui-lightness/jquery-ui.css">
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/ui-lightness/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Bitter" rel="stylesheet"> 
    @livewireStyles
    @vite(['resources/js/app.js', "resources/css/app.css", 'resources/sass/starsV2.scss'])
</head>
<body class="bg-gradient-to-r from-[#0d1d31] to-[#0c0d13]">
    {{ $slot }}
    @livewireScripts
</body>
</html>