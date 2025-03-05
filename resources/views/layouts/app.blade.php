<!DOCTYPE html>
<html lang="en">
<style>
    html, body {
    height: 100vh;
    margin: 0;
    overflow: hidden; /* Mencegah seluruh halaman bergulir */
    display: flex;
    flex-direction: column;
}

#layoutSidenav {
    display: flex;
    height: 100vh;
    overflow: hidden; /* Mencegah scroll di luar content */
}

#layoutSidenav_content {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    overflow: hidden;
}

main {
    flex-grow: 1;
    overflow: auto; /* Hanya bagian ini yang bisa di-scroll */
    padding: 20px;
    background: #f8f9fa;
    padding-bottom: 60px;
}

/* Pastikan footer selalu di bawah */
footer {
    padding: 10px 0;
    width: 100%;
    position: absolute;
    bottom: 0;
    left: 0;
}

</style>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title')</title>
    <link href="{{ asset('/template/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>
    @include('partials.navbar')
    <div id="layoutSidenav">
        @include('partials.sidebar')

        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            <footer>
                @include('partials.footer')
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('/template/js/scripts.js') }}"></script>
</body>
</html>