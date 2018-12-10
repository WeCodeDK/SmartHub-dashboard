<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <link href="{{ mix("css/app.css") }}" rel="stylesheet"/>
    <script src="{{ mix("js/app.js") }}" defer></script>
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    <meta name="google" value="notranslate">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    @yield('content')
</body>
</html>
