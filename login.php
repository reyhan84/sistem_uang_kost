<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="width: 25rem;">
            <h3 class="text-center">Login</h3>
            <form method="POST" action="login_proses.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <p class="text-center mt-3"><a href="register.php">Belum punya akun? Daftar</a></p>
            </form>
        </div>
    </div>
</body>
</html>
