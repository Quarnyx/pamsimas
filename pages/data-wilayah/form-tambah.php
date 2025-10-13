<form id="tambah-wilayah" enctype="multipart/form-data">
    <div class="d-grid gap-3">
        <div class="row">
            <div class="col-md-4">
                <label for="nama" class="form-label">Nama Wilayah</label>
                <input type="text" class="form-control" name="nama_wilayah" id="nama" placeholder="Nama Wilayah">
            </div>
            <div class="col-md-4">
                <label for="rt" class="form-label">RT</label>
                <input type="text" class="form-control" name="rt" id="rt" placeholder="00">
            </div>
            <div class="col-md-4">
                <label for="rw" class="form-label">RW</label>
                <input type="text" class="form-control" name="rw" id="rw" placeholder="00">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="Keterangan" class="form-label">Keterangan</label>
                <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan">
            </div>

        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>
<script>
    $("#tambah-wilayah").submit(function (e) {
        var formData = new FormData(this);

        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "modules/proses-wilayah.php?aksi=tambah-wilayah",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == "ok") {
                    loadTable();
                    $('.modal').modal('hide');
                    alertify.success('Wilayah Berhasil Ditambah');

                } else {
                    alertify.error('Wilayah Gagal Ditambah');

                }
            }
        });
    });
</script>