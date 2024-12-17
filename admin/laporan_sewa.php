<?php
// Koneksi ke database
include '../koneksi.php';

// Query data laporan sewa
$query = "SELECT penyewa.nama, kamar.nomor_kamar, penyewaan.tanggal_sewa, penyewaan.durasi 
          FROM penyewaan
          JOIN penyewa ON penyewaan.id_penyewa = penyewa.id_penyewa
          JOIN kamar ON penyewaan.id_kamar = kamar.id_kamar";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<div class="container mt-4">
    <h3>Laporan Sewa</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Penyewa</th>
                <th>Nomor Kamar</th>
                <th>Tanggal Sewa</th>
                <th>Durasi (bulan)</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['nomor_kamar']; ?></td>
                    <td><?= $row['tanggal_sewa']; ?></td>
                    <td><?= $row['durasi']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
