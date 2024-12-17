<div class="container mt-4">
    <h3>Menu Laporan</h3>
    <div class="row">
        <!-- Card Laporan Sewa -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Laporan Sewa</h5>
                    <p class="card-text">Lihat dan cetak laporan sewa kamar.</p>
                    <button class="btn btn-primary" onclick="generateLaporan('sewa')">Buat Laporan</button>
                </div>
            </div>
        </div>

        <!-- Card Laporan Keuangan -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Laporan Keuangan</h5>
                    <p class="card-text">Lihat dan cetak laporan transaksi keuangan.</p>
                    <button class="btn btn-primary" onclick="generateLaporan('keuangan')">Buat Laporan</button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Laporan -->
<div class="modal fade" id="modalLaporan" tabindex="-1" aria-labelledby="modalLaporanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLaporanLabel">Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="laporanContent">
                    <!-- Konten laporan akan dimuat di sini -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" onclick="printLaporan()">Cetak</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk membuat laporan
    function generateLaporan(type) {
        let url = '';
        let title = '';

        switch (type) {
            case 'sewa':
                url = 'laporan_sewa.php';
                title = 'Laporan Sewa';
                break;
            case 'keuangan':
                url = 'laporan_keuangan.php';
                title = 'Laporan Keuangan';
                break;
        }

        // Set judul modal
        document.getElementById('modalLaporanLabel').innerText = title;

        // Muat konten laporan
        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.getElementById('laporanContent').innerHTML = html;
                new bootstrap.Modal(document.getElementById('modalLaporan')).show();
            })
            .catch(error => {
                alert('Gagal memuat laporan: ' + error);
            });
    }

    // Fungsi untuk mencetak laporan dengan tampilan menarik
function printLaporan() {
    const printContent = document.getElementById('laporanContent').innerHTML;
    
    // Membuka jendela baru untuk cetak
    const newWindow = window.open('', '', 'width=800,height=600');
    
    // Menulis konten HTML ke jendela baru
    newWindow.document.write(`
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Cetak Laporan</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .header h1 {
                    margin: 0;
                    font-size: 24px;
                }
                .header p {
                    margin: 0;
                    font-size: 14px;
                    color: gray;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }
                table, th, td {
                    border: 1px solid black;
                }
                th, td {
                    padding: 10px;
                    text-align: center;
                }
                th {
                    background-color: #f2f2f2;
                }
                .footer {
                    margin-top: 30px;
                    text-align: center;
                    font-size: 12px;
                    color: gray;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Laporan Keuangan Kost</h1>
                <p>Dicetak pada: ${new Date().toLocaleDateString()} ${new Date().toLocaleTimeString()}</p>
            </div>
            
            ${printContent}

            <div class="footer">
                <p>© 2024 Sistem Informasi Kost. Semua Hak Dilindungi.</p>
            </div>
        </body>
        </html>
    `);

    newWindow.document.close(); // Menutup dokumen
    newWindow.focus();         // Fokus ke jendela cetak
    newWindow.print();         // Perintah cetak
    newWindow.close();         // Menutup jendela setelah cetak
}

</script>
