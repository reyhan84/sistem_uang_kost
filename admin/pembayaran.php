<?php
// Koneksi ke database
include '../koneksi.php';

// Proses tambah/edit pembayaran
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_payment'])) {
        // Menambah pembayaran
        $id_penyewa = $_POST['id_penyewa'];
        $metode_pembayaran = $_POST['metode_pembayaran'];
        $jumlah = $_POST['jumlah'];
        $tanggal = $_POST['tanggal'];

        $query = "INSERT INTO pembayaran (id_penyewa, metode_pembayaran, jumlah, tanggal) 
                  VALUES ('$id_penyewa', '$metode_pembayaran', '$jumlah', '$tanggal')";
        mysqli_query($conn, $query);
    } elseif (isset($_POST['add_method'])) {
        // Menambah metode pembayaran
        $metode_baru = $_POST['metode_baru'];
        $query = "INSERT INTO metode_pembayaran (nama_metode) VALUES ('$metode_baru')";
        mysqli_query($conn, $query);
    }
}

// Mengambil data pembayaran
$pembayaran = mysqli_query($conn, "SELECT p.*, py.nama 
                                   FROM pembayaran p 
                                   JOIN penyewa py ON p.id_penyewa = py.id_penyewa");

// Mengambil data metode pembayaran
$metode_pembayaran = mysqli_query($conn, "SELECT * FROM metode_pembayaran");

// Mengambil data penyewa
$penyewa = mysqli_query($conn, "SELECT * FROM penyewa");
?>

<div class="container mt-4">
    <h3>Manajemen Pembayaran</h3>
    <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalPembayaran">Tambah Pembayaran</button>
    <button class="btn btn-secondary my-3" data-bs-toggle="modal" data-bs-target="#modalMetode">Tambah Metode Pembayaran</button>

    <!-- Tabel Daftar Pembayaran -->
    <h5>Daftar Pembayaran</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Penyewa</th>
                <th>Metode Pembayaran</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; while ($row = mysqli_fetch_assoc($pembayaran)): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['metode_pembayaran']; ?></td>
                    <td>Rp <?= number_format($row['jumlah'], 0, ',', '.'); ?></td>
                    <td><?= $row['tanggal']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Riwayat Pembayaran -->
    <h5>Riwayat Pembayaran</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Penyewa</th>
                <th>Total Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $riwayat = mysqli_query($conn, "SELECT py.nama, SUM(p.jumlah) AS total 
                                            FROM pembayaran p 
                                            JOIN penyewa py ON p.id_penyewa = py.id_penyewa 
                                            GROUP BY py.nama");
            $i = 1;
            while ($row = mysqli_fetch_assoc($riwayat)): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td>Rp <?= number_format($row['total'], 0, ',', '.'); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Pembayaran -->
<div class="modal fade" id="modalPembayaran" tabindex="-1" aria-labelledby="modalPembayaranLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPembayaranLabel">Tambah Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="id_penyewa" class="form-label">Nama Penyewa</label>
                    <select class="form-select" id="id_penyewa" name="id_penyewa" required>
                        <?php while ($row = mysqli_fetch_assoc($penyewa)): ?>
                            <option value="<?= $row['id_penyewa']; ?>"><?= $row['nama']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                    <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                        <?php while ($row = mysqli_fetch_assoc($metode_pembayaran)): ?>
                            <option value="<?= $row['nama_metode']; ?>"><?= $row['nama_metode']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="add_payment" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Metode Pembayaran -->
<div class="modal fade" id="modalMetode" tabindex="-1" aria-labelledby="modalMetodeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMetodeLabel">Tambah Metode Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="metode_baru" class="form-label">Nama Metode</label>
                    <input type="text" class="form-control" id="metode_baru" name="metode_baru" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="add_method" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
