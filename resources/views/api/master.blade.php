<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    @yield('css')
    @yield('inline_style')
</head>

<body>
    @yield('content')
    @yield('js')
    @yield('inline_js')
</body>

</html>