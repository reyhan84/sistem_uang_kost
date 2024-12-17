<?php
// Koneksi ke database
include '../koneksi.php';

// Proses tambah/edit fasilitas
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save') {
    $id_fasilitas = $_POST['id_fasilitas'] ?? null;
    $nama_fasilitas = $_POST['nama_fasilitas'];
    $detail_fasilitas = $_POST['detail_fasilitas'];
    $status_fasilitas = $_POST['status_fasilitas'];

    if ($id_fasilitas) {
        // Edit fasilitas
        $query = "UPDATE fasilitas SET nama_fasilitas='$nama_fasilitas', detail_fasilitas='$detail_fasilitas', status_fasilitas='$status_fasilitas' WHERE id_fasilitas='$id_fasilitas'";
    } else {
        // Tambah fasilitas
        $query = "INSERT INTO fasilitas (nama_fasilitas, detail_fasilitas, status_fasilitas) VALUES ('$nama_fasilitas', '$detail_fasilitas', '$status_fasilitas')";
    }
    mysqli_query($conn, $query);
}

// Proses hapus fasilitas
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id_fasilitas = $_POST['id_fasilitas'];

    if ($id_fasilitas) {
        $query = "DELETE FROM fasilitas WHERE id_fasilitas = '$id_fasilitas'";
        if (mysqli_query($conn, $query)) {
            echo json_encode(['status' => 'success', 'message' => 'Fasilitas berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus fasilitas: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID fasilitas tidak valid']);
    }
    exit;
}

// Mengambil data fasilitas
$fasilitas = mysqli_query($conn, "SELECT * FROM fasilitas");
?>

<div class="container mt-4">
    <h3>Manajemen Fasilitas</h3>
    <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalFasilitas">Tambah Fasilitas</button>
    
    <!-- Tabel Daftar Fasilitas -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Fasilitas</th>
                <th>Detail</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; while ($row = mysqli_fetch_assoc($fasilitas)): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row['nama_fasilitas']; ?></td>
                    <td><?= $row['detail_fasilitas']; ?></td>
                    <td><?= $row['status_fasilitas'] == 'Baik' ? 'Baik' : 'Belum Baik'; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editFasilitas(<?= htmlspecialchars(json_encode($row)); ?>)">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="hapusFasilitas(<?= $row['id_fasilitas']; ?>)">Hapus</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah/Edit Fasilitas -->
<div class="modal fade" id="modalFasilitas" tabindex="-1" aria-labelledby="modalFasilitasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFasilitasLabel">Tambah/Edit Fasilitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_fasilitas" id="id_fasilitas">
                <input type="hidden" name="action" value="save">
                <div class="mb-3">
                    <label for="nama_fasilitas" class="form-label">Nama Fasilitas</label>
                    <input type="text" class="form-control" id="nama_fasilitas" name="nama_fasilitas" required>
                </div>
                <div class="mb-3">
                    <label for="detail_fasilitas" class="form-label">Detail</label>
                    <textarea class="form-control" id="detail_fasilitas" name="detail_fasilitas" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="status_fasilitas" class="form-label">Status</label>
                    <select class="form-select" id="status_fasilitas" name="status_fasilitas" required>
                        <option value="Baik">Baik</option>
                        <option value="Belum Baik">Belum Baik</option>
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
    // Mengisi form edit fasilitas
    function editFasilitas(data) {
        document.getElementById('id_fasilitas').value = data.id_fasilitas;
        document.getElementById('nama_fasilitas').value = data.nama_fasilitas;
        document.getElementById('detail_fasilitas').value = data.detail_fasilitas;
        document.getElementById('status_fasilitas').value = data.status_fasilitas;
        new bootstrap.Modal(document.getElementById('modalFasilitas')).show();
    }

    // Menghapus fasilitas
    function hapusFasilitas(id_fasilitas) {
        if (confirm('Apakah Anda yakin ingin menghapus fasilitas ini?')) {
            fetch('fasilitas.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=delete&id_fasilitas=${id_fasilitas}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    location.reload(); // Perbarui halaman
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus fasilitas.');
            });
        }
    }
</script>
