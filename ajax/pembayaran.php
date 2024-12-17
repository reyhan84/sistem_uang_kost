<?php
include '../includes/koneksi.php';

session_start();
$user_id = $_SESSION['user_id'];

$jumlah = $_POST['jumlah'];
$tanggal = $_POST['tanggal'];

$stmt = $conn->prepare("INSERT INTO pembayaran (nama_penghuni, jumlah_pembayaran, tanggal_bayar) VALUES ((SELECT nama FROM pengguna WHERE id = ?), ?, ?)");
$stmt->bind_param("ids", $user_id, $jumlah, $tanggal);
$stmt->execute();

echo "Pembayaran berhasil.";
?>
