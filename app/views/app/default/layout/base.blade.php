<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle or 'Big Bell' }}</title>
    @include('app.default.script.script_top')
</head>
<body>
    @yield('content-body')
    @include('app.default.script.script_bottom')
</body>
</html>     