<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'saveFasilitas') {
        $id = $_POST['id_fasilitas'];
        $nama = $_POST['nama_fasilitas'];
        $detail = $_POST['detail_fasilitas'];
        $status = $_POST['status_fasilitas'];

        if ($id) {
            // Update fasilitas
            $query = "UPDATE fasilitas SET nama_fasilitas='$nama', detail_fasilitas='$detail', status_fasilitas='$status' WHERE id_fasilitas='$id'";
            $message = "Fasilitas berhasil diperbarui!";
        } else {
            // Tambah fasilitas
            $query = "INSERT INTO fasilitas (nama_fasilitas, detail_fasilitas, status_fasilitas) VALUES ('$nama', '$detail', '$status')";
            $message = "Fasilitas berhasil ditambahkan!";
        }

        if (mysqli_query($conn, $query)) {
            echo $message;
        } else {
            echo "Terjadi kesalahan: " . mysqli_error($conn);
        }
    } elseif ($action === 'getFasilitas') {
        $id = $_POST['id'];
        $query = "SELECT * FROM fasilitas WHERE id_fasilitas='$id'";
        $result = mysqli_query($conn, $query);
        echo json_encode(mysqli_fetch_assoc($result));
    } elseif ($action === 'deleteFasilitas') {
        $id = $_POST['id'];
        $query = "DELETE FROM fasilitas WHERE id_fasilitas='$id'";
        if (mysqli_query($conn, $query)) {
            echo "Fasilitas berhasil dihapus!";
        } else {
            echo "Terjadi kesalahan: " . mysqli_error($conn);
        }
    }
} else {
    // Memuat daftar fasilitas
    $query = "SELECT * FROM fasilitas";
    $result = mysqli_query($conn, $query);
    $no = 1;

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$no}</td>
            <td>{$row['nama_fasilitas']}</td>
            <td>{$row['detail_fasilitas']}</td>
            <td>{$row['status_fasilitas']}</td>
            <td>
                <button class='btn btn-sm btn-warning edit-btn' data-id='{$row['id_fasilitas']}'>Edit</button>
                <button class='btn btn-sm btn-danger delete-btn' data-id='{$row['id_fasilitas']}'>Hapus</button>
            </td>
        </tr>";
        $no++;
    }
}
?>
