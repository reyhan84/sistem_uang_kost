<?php
require 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO pengguna (nama, username, password) VALUES ('$nama', '$username', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Registrasi berhasil. Silakan login.');
                window.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>
                alert('Registrasi gagal: " . mysqli_error($conn) . "');
                window.history.back();
              </script>";
    }
}
?>
