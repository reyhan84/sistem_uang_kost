<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'getPenyewa') {
        $id = $_POST['id'];
        $query = "SELECT * FROM penyewa WHERE id_penyewa = '$id'";
        $result = mysqli_query($conn, $query);
        echo json_encode(mysqli_fetch_assoc($result));
    } elseif ($action == 'updatePenyewa') {
        $id = $_POST['id_penyewa'];
        $nama = $_POST['nama'];
        $kontak = $_POST['kontak'];
        $alamat = $_POST['alamat'];
        $query = "UPDATE penyewa SET nama='$nama', kontak='$kontak', alamat='$alamat' WHERE id_penyewa='$id'";
        mysqli_query($conn, $query);
        echo "Data penyewa berhasil diperbarui!";
    } elseif ($action == 'deletePenyewa') {
        $id = $_POST['id'];
        $query = "DELETE FROM penyewa WHERE id_penyewa = '$id'";
        mysqli_query($conn, $query);
        echo "Data penyewa berhasil dihapus!";
    }
} else {
   // Menampilkan data penyewa
$query = "SELECT * FROM penyewa";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}

$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$no}</td>
            <td>{$row['nama']}</td>
            <td>{$row['kontak']}</td>
            <td>{$row['alamat']}</td>
            <td>{$row['catatan_khusus']}</td>
            <td>
                <button class='btn btn-sm btn-warning edit-btn' data-id='{$row['id_penyewa']}'>Edit</button>
                <button class='btn btn-sm btn-danger delete-btn' data-id='{$row['id_penyewa']}'>Hapus</button>
            </td>
          </tr>";
    $no++;
}

}
?>
