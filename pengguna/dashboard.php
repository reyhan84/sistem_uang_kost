<?php
session_start();
require '../koneksi.php'; // Pastikan file koneksi.php di-include dengan benar

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Ambil data pengguna yang login
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM penyewa WHERE id_pengguna = '$user_id'"; // Mengambil data profil pengguna dari tabel penyewa
$result = mysqli_query($conn, $sql);

// Jika data ditemukan, simpan ke dalam variabel $profil
if ($result && mysqli_num_rows($result) > 0) {
    $profil = mysqli_fetch_assoc($result);
} else {
    $profil = null; // Jika data tidak ditemukan, set profil menjadi null
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Sistem Uang Kost</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/sistem_uang_kost/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <!-- Halaman Dashboard -->

        <h3>Selamat Datang, <?= isset($profil['nama']) ? $profil['nama'] : 'Pengguna' ?></h3>
        <ul class="nav nav-tabs" id="dashboardTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profil-tab" data-bs-toggle="tab" data-bs-target="#profil" type="button" role="tab">Profil</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sewa-tab" data-bs-toggle="tab" data-bs-target="#sewa" type="button" role="tab">Sewa</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pembayaran-tab" data-bs-toggle="tab" data-bs-target="#pembayaran" type="button" role="tab">Pembayaran</button>
            </li>
        </ul>
        <div class="tab-content mt-3" id="dashboardTabContent">
            <!-- Profil -->
            <div class="tab-pane fade show active" id="profil" role="tabpanel">
                <h5>Informasi Profil</h5>
                <form id="formProfil" method="POST" action="profil_handler.php">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Penyewa</label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                            value="<?= isset($profil['nama']) ? $profil['nama'] : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="kontak" class="form-label">Kontak</label>
                        <input type="text" class="form-control" id="kontak" name="kontak" 
                            value="<?= isset($profil['kontak']) ? $profil['kontak'] : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2" required>
                            <?= isset($profil['alamat']) ? $profil['alamat'] : '' ?>
                        </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="catatan_khusus" class="form-label">Catatan Khusus</label>
                        <textarea class="form-control" id="catatan_khusus" name="catatan_khusus" rows="3">
                            <?= isset($profil['catatan_khusus']) ? $profil['catatan_khusus'] : '' ?>
                        </textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <?= isset($profil) ? 'Perbarui Profil' : 'Simpan Profil' ?>
                    </button>
                </form>
            </div>

            <!-- Sewa -->
            <div class="tab-pane fade" id="sewa" role="tabpanel">
    <h5>Sewa Kamar</h5>
    <form id="formSewa">
        <div class="mb-3">
            <label for="kamar" class="form-label">Pilih Kamar</label>
            <select class="form-select" id="kamar" name="kamar" required>
                <!-- Data kamar akan dimuat di sini -->
            </select>
        </div>
        <div id="detailKamar" class="mb-3">
            <!-- Detail kamar akan dimuat di sini -->
        </div>
        <div class="mb-3">
            <label for="durasi" class="form-label">Durasi Sewa (bulan)</label>
            <input type="number" class="form-control" id="durasi" name="durasi" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Sewa</button>
    </form>
</div>
<!-- Tambahkan div untuk debugging -->
<div id="debug"></div>
<script>
    $('#formSewa').submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: 'sewa_handler.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            alert(response); // Tampilkan pesan berhasil atau gagal
        },
        error: function() {
            alert('Terjadi kesalahan saat menyewa kamar.');
        }
    });
});

</script>



            <!-- Pembayaran -->
            <div class="tab-pane fade" id="pembayaran" role="tabpanel">
                <h5>Status Pembayaran</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Metode Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody id="statusPembayaran">
                        <!-- Data akan dimuat dengan AJAX -->
                    </tbody>
                </table>
                <form id="formPembayaran">
                    <h5 class="mt-4">Pembayaran Baru</h5>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah Pembayaran</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                    </div>
                    <div class="mb-3">
                        <label for="metode" class="form-label">Metode Pembayaran</label>
                        <select class="form-select" id="metode" name="metode" required>
                            <option value="transfer">Transfer Bank</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Bayar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
    $(document).ready(function() {
        // Event submit untuk Profil
        $('#formProfil').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'profil_handler.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert(response);
                }
            });
        });

        // Event submit untuk Sewa
        $('#formSewa').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: 'sewa_handler.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    alert(response); // Menampilkan respon dari server
                    location.reload(); // Refresh halaman setelah berhasil
                },
                error: function () {
                    alert('Gagal mengirim data.');
                }
            });
        });

        // Event submit untuk Pembayaran
        $('#formPembayaran').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'pembayaran_handler.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert(response);
                    loadPembayaran(); // Reload data pembayaran setelah berhasil
                }
            });
        });

        // Memuat data pembayaran dengan AJAX
        function loadPembayaran() {
            $.ajax({
                url: 'get_pembayaran.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let rows = '';
                    data.forEach(function(pembayaran, index) {
                        rows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${pembayaran.tanggal}</td>
                                <td>Rp${pembayaran.jumlah}</td>
                                <td>${pembayaran.metode_pembayaran}</td>
                            </tr>`;
                    });
                    $('#statusPembayaran').html(rows);
                },
                error: function () {
                    alert('Gagal memuat data pembayaran.');
                }
            });
        }

        // Memuat data metode pembayaran dengan AJAX
        function loadMetodePembayaran() {
            $.ajax({
                url: 'get_metode_pembayaran.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let metodeOptions = '';
                    data.forEach(function(metode) {
                        metodeOptions += `<option value="${metode.id_metode}">${metode.nama_metode}</option>`;
                    });
                    $('#metode').html(metodeOptions);
                },
                error: function () {
                    alert('Gagal memuat metode pembayaran.');
                }
            });
        }

        // Memuat data kamar saat halaman dimuat
        $.ajax({
            url: 'get_kamar.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                let kamarOptions = '';
                data.forEach(function (kamar) {
                    kamarOptions += `<option value="${kamar.id_kamar}">${kamar.nomor_kamar} - Rp${kamar.harga}</option>`;
                });
                $('#kamar').html(kamarOptions);

                // Memuat detail kamar pertama secara default
                if (data.length > 0) {
                    loadDetailKamar(data[0].id_kamar);
                }
            },
            error: function () {
                alert('Gagal memuat data kamar.');
            }
        });

        // Event change untuk memuat detail kamar
        $('#kamar').change(function () {
            const idKamar = $(this).val();
            loadDetailKamar(idKamar);
        });

        // Fungsi untuk memuat detail kamar
        function loadDetailKamar(idKamar) {
            $.ajax({
                url: 'get_detail_kamar.php',
                type: 'GET',
                data: { id_kamar: idKamar },
                dataType: 'json',
                success: function (data) {
                    if (data.error) {
                        $('#detailKamar').html(`<div class="alert alert-danger">${data.error}</div>`);
                    } else {
                        $('#detailKamar').html(`
                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Nomor Kamar:</strong> ${data.nomor_kamar}</p>
                                    <p><strong>Ukuran:</strong> ${data.ukuran}</p>
                                    <p><strong>Fasilitas:</strong> ${data.fasilitas}</p>
                                    <p><strong>Harga:</strong> Rp${data.harga}</p>
                                    <p><strong>Status:</strong> ${data.status}</p>
                                </div>
                            </div>
                        `);
                    }
                },
                error: function () {
                    $('#detailKamar').html('<div class="alert alert-danger">Gagal memuat detail kamar.</div>');
                }
            });
        }

        // Memuat data pembayaran dan metode pembayaran saat halaman dimuat
        loadPembayaran();
        loadMetodePembayaran();
    });
</script>

</body>
</html>
