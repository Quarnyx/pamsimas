<?php
include '../../modules/config.php';
$sql = "SELECT * FROM kategori_pengeluaran WHERE id = '$_POST[id]'";
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
                <label for="nama" class="form-label">Kode Kategori</label>
                <input type="text" class="form-control" name="kode_kategori" id="nama" placeholder="Kode Kategori"
                    value="<?php echo $row['kode_kategori']; ?>" readonly>
            </div>
            <div class="col-md-4">
                <label for="rt" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" name="nama_kategori" id="rt" placeholder="Nama Kategori"
                    value="<?php echo $row['nama_kategori']; ?>">
            </div>
            <div class="col-md-4">
                <label for="rw" class="form-label">Deskripsi</label>
                <input type="text" class="form-control" name="deskripsi" id="rw" placeholder="Deskripsi"
                    value="<?php echo $row['deskripsi']; ?>">
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
            url: 'modules/proses-jenis-pengeluaran.php?aksi=edit-jenis-pengeluaran',
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