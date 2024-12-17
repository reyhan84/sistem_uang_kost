<?php
// Koneksi ke database
include '../koneksi.php';

// Proses tambah/edit kamar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kamar = $_POST['id_kamar'] ?? null;
    $nomor_kamar = $_POST['nomor_kamar'];
    $ukuran = $_POST['ukuran'];
    $fasilitas = $_POST['fasilitas'] ?? [];
    error_log(print_r($_POST['fasilitas'], true)); // Cek data fasilitas
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    if ($id_kamar) {
        // Edit kamar
        $query = "UPDATE kamar SET nomor_kamar='$nomor_kamar', ukuran='$ukuran', harga='$harga', status='$status' WHERE id_kamar='$id_kamar'";
        mysqli_query($conn, $query);

        // Hapus relasi fasilitas lama
        mysqli_query($conn, "DELETE FROM kamar_fasilitas WHERE id_kamar='$id_kamar'");

        // Tambahkan relasi fasilitas baru
        foreach ($fasilitas as $id_fasilitas) {
            mysqli_query($conn, "INSERT INTO kamar_fasilitas (id_kamar, id_fasilitas) VALUES ('$id_kamar', '$id_fasilitas')");
        }
    } else {
        // Tambah kamar
        $query = "INSERT INTO kamar (nomor_kamar, ukuran, harga, status) VALUES ('$nomor_kamar', '$ukuran', '$harga', '$status')";
        mysqli_query($conn, $query);

        // Ambil ID kamar yang baru ditambahkan
        $id_kamar_baru = mysqli_insert_id($conn);

        // Tambahkan relasi fasilitas
        foreach ($fasilitas as $id_fasilitas) {
            mysqli_query($conn, "INSERT INTO kamar_fasilitas (id_kamar, id_fasilitas) VALUES ('$id_kamar_baru', '$id_fasilitas')");
        }
    }
}

// Proses hapus kamar
if (isset($_GET['hapus'])) {
    $id_kamar = intval($_GET['hapus']);

    // Hapus fasilitas terkait kamar
    mysqli_query($conn, "DELETE FROM kamar_fasilitas WHERE id_kamar='$id_kamar'");

    // Hapus kamar
    mysqli_query($conn, "DELETE FROM kamar WHERE id_kamar='$id_kamar'");
}

// Mengambil data kamar
$kamar = mysqli_query($conn, "SELECT * FROM kamar");

// Mengambil data fasilitas
$fasilitas = mysqli_query($conn, "SELECT * FROM fasilitas");
?>

<div class="container mt-4">
    <h3>Manajemen Kamar</h3>
    <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalKamar" onclick="resetForm()">Tambah Kamar</button>
    
    <!-- Tabel Daftar Kamar -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Kamar</th>
                <th>Ukuran</th>
                <th>Fasilitas</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; while ($row = mysqli_fetch_assoc($kamar)): ?>
                <?php
                // Ambil fasilitas untuk kamar ini
                $id_kamar = $row['id_kamar'];
                $resultFasilitas = mysqli_query($conn, "SELECT f.nama_fasilitas FROM kamar_fasilitas kf JOIN fasilitas f ON kf.id_fasilitas = f.id_fasilitas WHERE kf.id_kamar = '$id_kamar'");
                $namaFasilitas = [];
                while ($fasilitasRow = mysqli_fetch_assoc($resultFasilitas)) {
                    $namaFasilitas[] = $fasilitasRow['nama_fasilitas'];
                }
                ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row['nomor_kamar']; ?></td>
                    <td><?= $row['ukuran']; ?></td>
                    <td><?= implode(', ', $namaFasilitas); ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?= $row['status'] == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia'; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editKamar(<?= htmlspecialchars(json_encode([
                            'id_kamar' => $row['id_kamar'],
                            'nomor_kamar' => $row['nomor_kamar'],
                            'ukuran' => $row['ukuran'],
                            'harga' => $row['harga'],
                            'status' => $row['status'],
                            'fasilitas' => array_column(mysqli_fetch_all($resultFasilitas, MYSQLI_ASSOC), 'id_fasilitas')
                        ])); ?>)">Edit</button>
                        <a href="?page=kamar&hapus=<?= $row['id_kamar']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah/Edit Kamar -->
<div class="modal fade" id="modalKamar" tabindex="-1" aria-labelledby="modalKamarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKamarLabel">Tambah/Edit Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_kamar" id="id_kamar">
                <div class="mb-3">
                    <label for="nomor_kamar" class="form-label">Nomor Kamar</label>
                    <input type="text" class="form-control" id="nomor_kamar" name="nomor_kamar" required>
                </div>
                <div class="mb-3">
                    <label for="ukuran" class="form-label">Ukuran</label>
                    <input type="text" class="form-control" id="ukuran" name="ukuran" required>
                </div>
                <div class="mb-3">
                    <label for="fasilitas" class="form-label">Fasilitas</label>
                    <div id="fasilitasCheckbox">
    <?php while ($fasilitasRow = mysqli_fetch_assoc($fasilitas)): ?>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="fasilitas[]" value="<?= $fasilitasRow['id_fasilitas']; ?>" id="fasilitas_<?= $fasilitasRow['id_fasilitas']; ?>">
            <label class="form-check-label" for="fasilitas_<?= $fasilitasRow['id_fasilitas']; ?>">
                <?= $fasilitasRow['nama_fasilitas']; ?>
            </label>
        </div>
    <?php endwhile; ?>
</div>

                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="tidak tersedia">Tidak Tersedia</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Mengisi form edit kamar
    function editKamar(data) {
        document.getElementById('id_kamar').value = data.id_kamar;
        document.getElementById('nomor_kamar').value = data.nomor_kamar;
        document.getElementById('ukuran').value = data.ukuran;
        document.getElementById('harga').value = data.harga;
        document.getElementById('status').value = data.status;

        // Reset fasilitas checkbox
        document.querySelectorAll('#fasilitasCheckbox input').forEach(input => {
            input.checked = false;
        });

        // Set fasilitas yang dipilih
        if (Array.isArray(data.fasilitas)) {
            data.fasilitas.forEach(id => {
                document.getElementById('fasilitas_' + id).checked = true;
            });
        }

        new bootstrap.Modal(document.getElementById('modalKamar')).show();
    }

    // Reset form tambah kamar
    function resetForm() {
        document.getElementById('id_kamar').value = '';
        document.getElementById('nomor_kamar').value = '';
        document.getElementById('ukuran').value = '';
        document.getElementById('harga').value = '';
        document.getElementById('status').value = 'tersedia';

        // Reset fasilitas checkbox
        document.querySelectorAll('#fasilitasCheckbox input').forEach(input => {
            input.checked = false;
        });
    }
</script>
