<?php
include '../koneksi.php';

$query = "SELECT id_metode, nama_metode FROM metode_pembayaran";
$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
