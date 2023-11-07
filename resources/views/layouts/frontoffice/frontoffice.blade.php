@props(['dir'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{$dir ? 'rtl' : 'ltr'}}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>CDC Unand</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/frontoffice/favicon.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CDC UNAND{{env('APP_NAME')}}</title>
    @include('partials.frontoffice._head')

</head>
<body class="" > 
@include('partials.frontoffice._body')
</body>
</html>
