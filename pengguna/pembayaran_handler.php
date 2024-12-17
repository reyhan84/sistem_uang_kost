<?php
include '../koneksi.php';
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo "Akses ditolak. Silakan login terlebih dahulu.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_penyewa = $_SESSION['user_id'];
    $jumlah = $_POST['jumlah'];
    $metode_pembayaran = $_POST['metode'];
    $tanggal = date('Y-m-d');

    $query = "INSERT INTO pembayaran (id_penyewa, jumlah, metode_pembayaran, tanggal) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiss", $id_penyewa, $jumlah, $metode_pembayaran, $tanggal);

    if ($stmt->execute()) {
        echo "Pembayaran berhasil disimpan.";
    } else {
        echo "Terjadi kesalahan saat menyimpan pembayaran.";
    }
} else {
    echo "Metode request tidak valid.";
}
?>
