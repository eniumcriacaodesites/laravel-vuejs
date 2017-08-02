<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CodeBills') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/site.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body id="app">

<header>
    <?php
    $menuConfig = [
        'auth' => Auth::check(),
        'name' => Auth::check() ? Auth::user()->name : '',
        'menus' => [
            ['name' => 'Home', 'url' => url('/'), 'active' => isRouteActive('site.home')],
        ],
        'menusDropdown' => [],
        'urlLogout' => env('URL_SITE_LOGOUT'),
        'csrfToken' => csrf_token()
    ];
    ?>
    <site-menu :config="{{ json_encode($menuConfig) }}"></site-menu>
</header>

<main>
    @yield('content')
</main>

<footer>
    <h6 class="center-align">&copy; {{ date('Y') }} - CodeBills</h6>
</footer>

<!-- Scripts -->
@stack('scripts')
<script src="{{ asset('build/site.bundle.js') }}"></script>
</body>
</html>
