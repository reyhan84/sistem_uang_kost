<?php
session_start(); // Memulai sesi untuk menyimpan data pengguna
require 'koneksi.php'; // Menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form login
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Query untuk mencari pengguna berdasarkan username
    $sql = "SELECT * FROM pengguna WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Jika password cocok, simpan data user ke session
            $_SESSION['user_id'] = $user['id'];  // Simpan ID pengguna dalam session
            $_SESSION['username'] = $user['username'];  // Simpan username dalam session
            $_SESSION['role'] = $user['role'];  // Simpan peran pengguna (admin/pengguna)

            // Redirect berdasarkan peran
            if ($user['role'] == 'admin') {
                // Jika admin, arahkan ke halaman dashboard admin
                header('Location: admin/dashboard.php');
            } else {
                // Jika pengguna biasa, arahkan ke halaman dashboard pengguna
                header('Location: pengguna/dashboard.php');
            }
            exit;
        } else {
            // Jika password tidak cocok
            echo "<script>
                    alert('Username atau Password salah!');
                    window.history.back();
                  </script>";
        }
    } else {
        // Jika username tidak ditemukan
        echo "<script>
                alert('Username atau Password salah!');
                window.history.back();
              </script>";
    }
}
?>
