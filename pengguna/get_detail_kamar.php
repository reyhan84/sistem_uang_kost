<?php
include '../koneksi.php'; // Pastikan koneksi ke database

if (isset($_GET['id_kamar'])) {
    $id_kamar = $_GET['id_kamar'];

    // Query untuk mengambil detail kamar dan fasilitasnya
    $query = "
        SELECT 
            k.nomor_kamar, 
            k.ukuran, 
            GROUP_CONCAT(f.nama_fasilitas SEPARATOR ', ') AS fasilitas,
            k.harga, 
            k.status
        FROM kamar k
        LEFT JOIN kamar_fasilitas kf ON k.id_kamar = kf.id_kamar
        LEFT JOIN fasilitas f ON kf.id_fasilitas = f.id_fasilitas
        WHERE k.id_kamar = ?
        GROUP BY k.id_kamar
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_kamar);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $kamar = $result->fetch_assoc();
        echo json_encode($kamar);
    } else {
        echo json_encode(['error' => 'Kamar tidak ditemukan']);
    }
} else {
    echo json_encode(['error' => 'ID kamar tidak diberikan']);
}
?>
