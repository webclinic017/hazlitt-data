<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate() !!}
    <link rel="stylesheet" type="text/css" href="{!! asset('css/app.css') !!}">
</head>

<body class="bg-dark-mode">
    {{-- @include('main.partials.header') --}}

    @yield('content')

    {{-- @include('main.partials.footer') --}}

    @push('scripts')
        <script src="{!! asset('js/app.js') !!}"></script>
    @endpush
    @stack('scripts')
</body>

</html>