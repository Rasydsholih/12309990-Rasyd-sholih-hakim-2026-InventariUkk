<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyApp</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


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
    @include('inventaris.navbar')



    <!-- Content -->
    <div class="content">
        <div class="container py-5">
            @if(session('success'))
                <div class="container py-4">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @if(!auth()->check())
        @include('auth.modal-login')
    @endif
</body>

</html>