<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh;
            background-color: #007bff;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #0056b3;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center"><a href="dashboard.php">Admin Panel</a></h4>
        <a href="?page=penyewa">Penyewa</a>
        <a href="?page=kamar">Kamar</a>
        <a href="?page=pembayaran">Pembayaran</a>
        <a href="?page=fasilitas">Fasilitas</a>
        <a href="?page=laporan">Laporan</a>
        <a href="/sistem_uang_kost/logout.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <?php
        // Menampilkan konten berdasarkan menu yang dipilih
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $file = __DIR__ . "/$page.php"; // Mencari file langsung dari root admin
            if (file_exists($file)) {
                include $file; // Memuat file yang ditemukan
            } else {
                echo "<h4>Halaman tidak ditemukan!</h4>";
            }
        } else {
            echo "<h4>Selamat datang di dashboard admin!</h4>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
