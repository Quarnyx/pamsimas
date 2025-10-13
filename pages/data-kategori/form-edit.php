<?php
include '../../modules/config.php';
$sql = "SELECT * FROM kategori_pelanggan WHERE id = '$_POST[id]'";
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
                <label for="nama" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" name="nama_kategori" id="nama" placeholder="Nama Kategori"
                    value="<?= $row['nama_kategori'] ?>">
            </div>
            <div class="col-md-4">
                <label for="kode" class="form-label">Kode Kategori</label>
                <input type="text" class="form-control" name="kode_kategori" id="kode"
                    value="<?= $row['kode_kategori'] ?>" readonly>
            </div>
            <div class="col-md-4">
                <label for="beban_tetap" class="form-label">Beban Tetap</label>
                <input type="text" class="form-control" name="beban_tetap" id="beban_tetap" placeholder="2000"
                    value="<?= $row['beban_tetap'] ?>">
            </div>
        </div>
        <div class="row">
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
            url: 'modules/proses-kategori.php?aksi=edit-kategori',
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