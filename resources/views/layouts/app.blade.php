<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate() !!}
    <link rel="stylesheet" type="text/css" href="{!! asset('css/app.css') !!}">
    <link href="https://fonts.googleapis.com/css?family=Aldrich&display=swap" rel="stylesheet">
</head>

<body class="bg-dark-mode">
    @include('partials.topbar')
    <section class="main flex mx-8">
        @include('partials.sidebar')
        <div class="content w-5/6 bg-dark-mode-light rounded-l-lg shadow-inner-dark text-old-gray p-8">
            @yield('content')
        </div>
    </section>
    {{-- @include('main.partials.footer') --}}

    @push('scripts')
    <script src="{!! asset('js/app.js') !!}"></script>
    @endpush
    @stack('scripts')
</body>

</html>