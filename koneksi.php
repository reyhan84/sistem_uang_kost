<?php
// Konfigurasi database
$host = "localhost";     // Host database (biasanya localhost)
$user = "root";          // Username database (sesuaikan dengan pengaturan Anda)
$password = "";          // Password database (kosong jika menggunakan XAMPP default)
$dbname = "kost_system"; // Nama database Anda

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
