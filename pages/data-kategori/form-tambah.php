<form id="tambah-kategori" enctype="multipart/form-data">
    <div class="d-grid gap-3">
        <div class="row">
            <div class="col-md-4">
                <label for="nama" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" name="nama_kategori" id="nama" placeholder="Nama Kategori">
            </div>
            <div class="col-md-4">
                <label for="kode" class="form-label">Kode Kategori</label>
                <?php
                require_once '../../modules/config.php';
                $query = "SELECT RIGHT(kode_kategori, 3) AS kode FROM kategori_pelanggan ORDER BY kode_kategori DESC LIMIT 1";
                $result = mysqli_query($conn, $query);
                $lastCode = 1;
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    if (isset($row['kode']) && $row['kode'] !== null && $row['kode'] !== '') {
                        $lastCode = (int) $row['kode'] + 1;
                    }
                }
                $newCode = 'KP-' . str_pad($lastCode, 3, '0', STR_PAD_LEFT);
                ?>
                <input type="text" class="form-control" name="kode_kategori" id="kode" value="<?php echo $newCode; ?>"
                    readonly>
            </div>
            <div class="col-md-4">
                <label for="beban_tetap" class="form-label">Beban Tetap</label>
                <input type="text" class="form-control" name="beban_tetap" id="beban_tetap" placeholder="2000">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <input type="text" class="form-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi">
            </div>

        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>
<script>
    $("#tambah-kategori").submit(function (e) {
        var formData = new FormData(this);

        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "modules/proses-kategori.php?aksi=tambah-kategori",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == "ok") {
                    loadTable();
                    $('.modal').modal('hide');
                    alertify.success('Kategori Berhasil Ditambah');

                } else {
                    alertify.error('Kategori Gagal Ditambah');

                }
            }
        });
    });
</script>