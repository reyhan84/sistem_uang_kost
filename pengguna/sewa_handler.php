<?php
include '../koneksi.php';
session_start();

// Debugging awal
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo "Akses ditolak. Silakan login terlebih dahulu.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari session dan form
    $id_penyewa = $_SESSION['user_id'];
    $id_kamar = $_POST['kamar'];
    $durasi = $_POST['durasi'];
    $tanggal_sewa = date('Y-m-d');
    $tanggal_berakhir = date('Y-m-d', strtotime("+$durasi months"));

    // Validasi input
    if (empty($id_kamar) || empty($durasi)) {
        echo "Harap isi semua data.";
        exit;
    }

    // Simpan data penyewaan ke tabel `penyewaan`
    $query = "INSERT INTO penyewaan (id_penyewa, id_kamar, tanggal_sewa, durasi) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Kesalahan prepare: " . $conn->error);
    }

    $stmt->bind_param("iisi", $id_penyewa, $id_kamar, $tanggal_sewa, $durasi);

    if ($stmt->execute()) {
        // Update status kamar menjadi 'tidak tersedia'
        $updateQuery = "UPDATE kamar SET status = 'tidak tersedia' WHERE id_kamar = ?";
        $stmt = $conn->prepare($updateQuery);

        if (!$stmt) {
            die("Kesalahan prepare update: " . $conn->error);
        }

        $stmt->bind_param("i", $id_kamar);
        $stmt->execute();

        echo "Penyewaan berhasil disimpan.";
    } else {
        echo "Terjadi kesalahan saat menyimpan penyewaan: " . $stmt->error;
    }
} else {
    echo "Metode request tidak valid.";
}


// Debugging query error
if ($stmt->error) {
    echo "Error saat eksekusi query: " . $stmt->error;
}

?>
