<div class="container mt-4">
<h3>Daftar Penyewa</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kontak</th>
            <th>Alamat</th>
            <th>Catatan Khusus</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="penyewaData">
        <!-- Data penyewa akan dimuat dengan AJAX -->
    </tbody>
</table>

<!-- Modal Edit Penyewa -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Penyewa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPenyewaForm">
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id_penyewa">
                    <div class="mb-3">
                        <label for="editNama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="editNama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="editKontak" class="form-label">Kontak</label>
                        <input type="text" class="form-control" id="editKontak" name="kontak" required>
                    </div>
                    <div class="mb-3">
                        <label for="editAlamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="editAlamat" name="alamat" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Tambahkan Jquery dan Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-UG8ao2jwOWB7/oDdObZc6ItJmwUkR/PfMyt9Qs5AwX7PsnYn1CRKCTWyncPTWvaS" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Memuat data penyewa
        function loadPenyewa() {
            $.ajax({
                url: 'penyewa_process.php',
                method: 'GET',
                success: function(data) {
                    $('#penyewaData').html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                    alert("Gagal memuat data penyewa!");
                }
            });
        }

        loadPenyewa();

        // Edit penyewa
        $(document).on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            $.ajax({
                url: 'penyewa_process.php',
                method: 'POST',
                data: { action: 'getPenyewa', id: id },
                dataType: 'json',
                success: function(response) {
                    $('#editId').val(response.id_penyewa);
                    $('#editNama').val(response.nama);
                    $('#editKontak').val(response.kontak);
                    $('#editAlamat').val(response.alamat);
                    $('#editModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                    alert("Gagal mengambil data penyewa!");
                }
            });
        });

        // Submit perubahan penyewa
        $('#editPenyewaForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'penyewa_process.php',
                method: 'POST',
                data: $(this).serialize() + '&action=updatePenyewa',
                success: function(response) {
                    alert(response);
                    $('#editModal').modal('hide');
                    loadPenyewa();
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                    alert("Gagal memperbarui data penyewa!");
                }
            });
        });

        // Hapus penyewa
        $(document).on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus penyewa ini?')) {
                $.ajax({
                    url: 'penyewa_process.php',
                    method: 'POST',
                    data: { action: 'deletePenyewa', id: id },
                    success: function(response) {
                        alert(response);
                        loadPenyewa();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error);
                        alert("Gagal menghapus penyewa!");
                    }
                });
            }
        });
    });
</script>
