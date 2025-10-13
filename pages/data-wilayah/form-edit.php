<?php
include '../../modules/config.php';
$sql = "SELECT * FROM wilayah WHERE id = '$_POST[id]'";
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
                <label for="nama" class="form-label">Nama Wilayah</label>
                <input type="text" class="form-control" name="nama_wilayah" id="nama" placeholder="Nama Wilayah"
                    value="<?= $row['nama_wilayah'] ?>">
            </div>
            <div class="col-md-4">
                <label for="rt" class="form-label">RT</label>
                <input type="text" class="form-control" name="rt" id="rt" placeholder="00" value="<?= $row['rt'] ?>">
            </div>
            <div class="col-md-4">
                <label for="rw" class="form-label">RW</label>
                <input type="text" class="form-control" name="rw" id="rw" placeholder="00" value="<?= $row['rw'] ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="Keterangan" class="form-label">Keterangan</label>
                <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan"
                    value="<?= $row['keterangan'] ?>">
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
            url: 'modules/proses-wilayah.php?aksi=edit-wilayah',
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