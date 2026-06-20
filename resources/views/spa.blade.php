<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SPA App</title>
    @vite(['resources/js/spa/main.ts', 'resources/css/spa.css'])
</head>
<body>
<div id="app"></div>
</body>
</html>
