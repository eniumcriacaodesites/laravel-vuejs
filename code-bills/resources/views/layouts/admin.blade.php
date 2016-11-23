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
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body id="app">

<header>
    @if(Auth::check())
        @include('layouts._menu')
    @else
        <div class="navbar-fixed">
            <nav>
                <div class="nav-wrapper container">
                    <div class="brand-logo center">CodeBills</div>
                </div>
            </nav>
        </div>
    @endif
</header>

<main>
    @yield('content')
</main>

<footer>
    <h6 class="center-align">&copy; 2016 - CodeBills</h6>
</footer>

<!-- Scripts -->
<script src="{{ asset('build/admin.bundle.js') }}"></script>
</body>
</html>
