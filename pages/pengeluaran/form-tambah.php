<?php
require_once '../../modules/config.php';
session_start();
$user_id = $_SESSION['user_id'];

?>
<form id="tambah-transaksi-pengeluaran" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?= $user_id ?>">
    <div class="d-grid gap-3">
        <div class="row">
            <div class="col-md-4">
                <label for="nama" class="form-label">Kategori</label>
                <?php
                $queryKategori = "SELECT kode_kategori, nama_kategori, id FROM kategori_pengeluaran";
                $resultKategori = mysqli_query($conn, $queryKategori);
                ?>
                <select class="form-select" name="kategori_pengeluaran" id="nama" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    <?php
                    while ($rowKategori = mysqli_fetch_assoc($resultKategori)) {
                        echo "<option value='" . $rowKategori['id'] . "'>" . $rowKategori['nama_kategori'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="rt" class="form-label">Jumlah</label>
                <input type="text" class="form-control" name="jumlah" id="rt" placeholder="Jumlah">
            </div>
            <div class="col-md-4">
                <label for="rw" class="form-label">Tanggal</label>
                <input type="date" class="form-control" name="tanggal_pengeluaran" id="rw" placeholder="Tanggal">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="penerima" class="form-label">Penerima</label>
                <input type="text" class="form-control" name="penerima" id="penerima" placeholder="Penerima">
            </div>
            <div class="col-md-6">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <input type="text" class="form-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>
<script>
    $("#tambah-transaksi-pengeluaran").submit(function (e) {
        var formData = new FormData(this);

        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "modules/proses-pengeluaran.php?aksi=tambah-transaksi-pengeluaran",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == "ok") {
                    loadTable();
                    $('.modal').modal('hide');
                    alertify.success('Transaksi Pengeluaran Berhasil Ditambah');

                } else {
                    alertify.error('Transaksi Pengeluaran Gagal Ditambah');

                }
            }
        });
    });
</script>