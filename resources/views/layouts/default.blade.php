<!DOCTYPE html>
<html>

<head>
    <title>@yield('title', 'Weibo App') - Laravel 入门教程</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body>

    @include('layouts.header')

    <div class="container">
        @include('shared._messages')
        @yield('content')
        @include('layouts.footer')
    </div>
</body>
<script src="{{ mix('js/app.js') }}"></script>

</html>
