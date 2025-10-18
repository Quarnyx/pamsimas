<?php
include '../../modules/config.php';
$sql = "SELECT * FROM pengeluaran WHERE id = '$_POST[id]'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>
<form id="form-edit" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
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
                        echo "<option value='" . $rowKategori['id'] . "' " . ($rowKategori['id'] == $row['kategori_pengeluaran_id'] ? 'selected' : '') . ">" . $rowKategori['nama_kategori'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="rt" class="form-label">Jumlah</label>
                <input type="text" class="form-control" name="jumlah" id="rt" placeholder="Jumlah"
                    value="<?= $row['jumlah'] ?>">
            </div>
            <div class="col-md-4">
                <label for="rw" class="form-label">Tanggal</label>
                <input type="date" class="form-control" name="tanggal_pengeluaran" id="rw" placeholder="Tanggal"
                    value="<?= $row['tanggal_pengeluaran'] ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="penerima" class="form-label">Penerima</label>
                <input type="text" class="form-control" name="penerima" id="penerima" placeholder="Penerima"
                    value="<?= $row['penerima'] ?>">
            </div>
            <div class="col-md-6">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <input type="text" class="form-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi"
                    value="<?= $row['deskripsi'] ?>">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>
<script>
    $("#form-edit").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'modules/proses-pengeluaran.php?aksi=edit-transaksi-pengeluaran',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == "ok") {
                    loadTable();
                    $('.modal').modal('hide');
                    alertify.success('Edit Berhasil');

                } else {
                    alertify.error('Edit Gagal');

                }
            },
            error: function (data) {
                alertify.error(data);
            }
        });
    });
</script>