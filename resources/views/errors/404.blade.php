<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
        }

        .error-container {
            height: 100vh;
        }

        .btn-back {
            background-color: #3b82f6;
            color: white;
            border-radius: 10px;
            padding: 8px 25px;
        }

        .btn-back:hover {
            background-color: #2563eb;
            color: white;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center error-container">
    <div class="text-center">

        <!-- GANTI GAMBAR DI SINI -->
        <img src="#" alt="404"  width="900" class="error-img mb-4">

        <h4 class="fw-semibold mb-3">You can't access this page.</h4>

        <a href="/" class="btn btn-back">
            Back
        </a>

    </div>
</div>

</body>
</html>