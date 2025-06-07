<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking - @yield('title', 'Booking')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            background-color: #d9f8dd;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 128, 0, 0.1);
            border-radius: 15px;
        }

        .card-header {
            background: #d9f8dd;
            color: #2f8f46;
            border-bottom: 1px solid #cdeccd;
            border-radius: 15px 15px 0 0;
        }

        .btn-primary {
            background-color: #38a169;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2f855a;
        }

        footer {
            background-color: #d9f8dd;
            padding: 1rem 0;
            text-align: center;
            color: #2f8f46;
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('partials.header')

    <main class="container py-4">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
