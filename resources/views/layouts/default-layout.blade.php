@props([
    'title' => config('app.name'),
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/metro/easyui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/icon.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    {{ $slot }}

    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.easyui.min.js') }}"></script>
</body>

</html>
