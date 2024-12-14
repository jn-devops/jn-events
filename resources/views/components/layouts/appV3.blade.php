<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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