<?php
include '../koneksi.php';

$query = "SELECT * FROM kamar WHERE status = 'tersedia'";
$result = $conn->query($query);

$kamar = [];
while ($row = $result->fetch_assoc()) {
    $kamar[] = $row;
}

header('Content-Type: application/json');
echo json_encode($kamar);
?>
