<style>
body {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    background-color: #f8f9fa;
}
</style>
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('partials.navhome')
    <div class="content">
        @yield('content')
    </div>
</body>
</html>