<form id="tambah-jenis-pengeluaran" enctype="multipart/form-data">
    <div class="d-grid gap-3">
        <div class="row">
            <div class="col-md-4">
                <label for="nama" class="form-label">Kode Kategori</label>
                <?php
                require_once '../../modules/config.php';
                $query = "SELECT RIGHT(kode_kategori, 3) AS kode FROM kategori_pengeluaran ORDER BY kode_kategori DESC LIMIT 1";
                $result = mysqli_query($conn, $query);
                $lastCode = 1;
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    if (isset($row['kode']) && $row['kode'] !== null && $row['kode'] !== '') {
                        $lastCode = (int) $row['kode'] + 1;
                    }
                }
                $newCode = 'PK-' . str_pad($lastCode, 3, '0', STR_PAD_LEFT);
                ?>
                <input type="text" class="form-control" name="kode_kategori" id="nama" placeholder="Kode Kategori"
                    value="<?php echo $newCode; ?>" readonly>
            </div>
            <div class="col-md-4">
                <label for="rt" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" name="nama_kategori" id="rt" placeholder="Nama Kategori">
            </div>
            <div class="col-md-4">
                <label for="rw" class="form-label">Deskripsi</label>
                <input type="text" class="form-control" name="deskripsi" id="rw" placeholder="Deskripsi">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>
<script>
    $("#tambah-jenis-pengeluaran").submit(function (e) {
        var formData = new FormData(this);

        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "modules/proses-jenis-pengeluaran.php?aksi=tambah-jenis-pengeluaran",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == "ok") {
                    loadTable();
                    $('.modal').modal('hide');
                    alertify.success('Jenis Pengeluaran Berhasil Ditambah');

                } else {
                    alertify.error('Jenis Pengeluaran Gagal Ditambah');

                }
            }
        });
    });
</script>