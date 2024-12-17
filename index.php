<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pembayaran Uang Kost</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }
        .card {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .btn-custom {
            background-color: #6a11cb;
            border-color: #6a11cb;
        }
        .btn-custom:hover {
            background-color: #2575fc;
            border-color: #2575fc;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center p-4">
                    <h1 class="mb-4">Sistem Pembayaran Uang Kost</h1>
                    <p class="mb-4">Kelola keuangan kost Anda dengan mudah dan efisien.</p>
                    <div class="d-grid gap-2">
                        <a href="login.php" class="btn btn-custom btn-lg text-white">Get Start</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
