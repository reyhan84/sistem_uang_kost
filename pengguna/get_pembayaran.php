<?php
include '../koneksi.php';
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$id_penyewa = $_SESSION['user_id'];

$query = "SELECT p.tanggal, p.jumlah, mp.nama_metode AS metode_pembayaran 
          FROM pembayaran p 
          LEFT JOIN metode_pembayaran mp ON p.metode_pembayaran = mp.id_metode 
          WHERE p.id_penyewa = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_penyewa);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
