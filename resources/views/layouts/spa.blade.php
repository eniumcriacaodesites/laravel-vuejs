<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'CodeBills') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/spa.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'pusher' => [
                'key' => env('PUSHER_KEY'),
                'cluster' => env('PUSHER_CLUSTER'),
            ]
        ]); ?>
    </script>
</head>
<body id="app">

<app-component></app-component>

<!-- Scripts -->
<script src="{{ asset('build/spa.bundle.js') }}"></script>
</body>
</html>
