<?php
include 'includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO pengguna (nama, username, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $username, $password);
    $stmt->execute();

    echo "Registrasi berhasil.";
}
?>