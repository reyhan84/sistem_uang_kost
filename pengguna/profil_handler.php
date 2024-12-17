<?php
// Pastikan file koneksi di-include
include '../koneksi.php'; 
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo "Akses ditolak. Silakan login terlebih dahulu.";
    exit;
}

// Periksa apakah request adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari session dan form
    $id_pengguna = $_SESSION['user_id']; // Gunakan 'user_id' sesuai session di login_proses.php
    $nama = trim($_POST['nama']);
    $kontak = trim($_POST['kontak']);
    $alamat = trim($_POST['alamat']);
    $catatan_khusus = trim($_POST['catatan_khusus']);

    // Periksa apakah data penyewa sudah ada di database
    $query = "SELECT * FROM penyewa WHERE id_pengguna = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update data jika sudah ada
        $query = "UPDATE penyewa SET nama = ?, kontak = ?, alamat = ?, catatan_khusus = ? WHERE id_pengguna = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $nama, $kontak, $alamat, $catatan_khusus, $id_pengguna);
    } else {
        // Insert data jika belum ada
        $query = "INSERT INTO penyewa (id_pengguna, nama, kontak, alamat, catatan_khusus) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issss", $id_pengguna, $nama, $kontak, $alamat, $catatan_khusus);
    }

    // Eksekusi query
    if ($stmt->execute()) {
        echo "Profil berhasil disimpan.";
    } else {
        echo "Terjadi kesalahan saat menyimpan profil: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
} else {
    echo "Metode request tidak valid.";
}

// Tutup koneksi
$conn->close();
?>
