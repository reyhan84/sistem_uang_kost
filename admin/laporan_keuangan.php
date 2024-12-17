<?php
include '../koneksi.php';

// Query untuk mengambil data pembayaran dengan join ke tabel penyewa
$query = "SELECT pembayaran.*, penyewa.nama AS nama_penyewa
          FROM pembayaran
          JOIN penyewa ON pembayaran.id_penyewa = penyewa.id_penyewa";
$result = mysqli_query($conn, $query);

// Cek apakah query berhasil
if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}

$total = 0;
echo '<table class="table table-bordered">';
echo '<thead>';
echo '<tr><th>No</th><th>Nama Penyewa</th><th>Jumlah</th><th>Tanggal Pembayaran</th></tr>';
echo '</thead>';
echo '<tbody>';
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    // Pastikan setiap kolom yang ingin ditampilkan ada
    echo "<tr>
            <td>{$no}</td>
            <td>{$row['nama_penyewa']}</td>
            <td>Rp " . number_format($row['jumlah'], 0, ',', '.') . "</td>
            <td>{$row['tanggal']}</td> <!-- Pastikan nama kolomnya benar -->
          </tr>";
    $total += $row['jumlah'];
    $no++;
}
echo '</tbody>';
echo '</table>';
echo "<h5>Total: Rp " . number_format($total, 0, ',', '.') . "</h5>";
?>
