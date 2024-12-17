<?php
include '../includes/koneksi.php';

session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id_pengguna'])) {
    // Jika tidak, redirect ke halaman login
    header("Location: index.php");
    exit();
}
?>

