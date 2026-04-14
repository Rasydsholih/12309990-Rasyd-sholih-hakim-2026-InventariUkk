<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyApp</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8fafc;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            border: none;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Content -->
    <div class="container py-4">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('modal')

    @include('auth.modal-login')
</body>

</html>