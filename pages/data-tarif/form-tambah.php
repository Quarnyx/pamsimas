<form id="tambah-tarif" enctype="multipart/form-data">
    <div class="d-grid gap-3">
        <div class="row">
            <div class="col-md-4">
                <label for="nama" class="form-label">Nama Kategori</label>
                <?php
                require_once '../../modules/config.php';
                $takeKategori = "SELECT * FROM kategori_pelanggan";
                $resultKategori = mysqli_query($conn, $takeKategori);
                ?>
                <select class="form-select" name="kategori_id" id="nama">
                    <option value="" selected disabled>-- Pilih Kategori --</option>
                    <?php
                    if ($resultKategori && mysqli_num_rows($resultKategori) > 0) {
                        while ($rowKategori = mysqli_fetch_assoc($resultKategori)) {
                            echo '<option value="' . $rowKategori['id'] . '">' . $rowKategori['nama_kategori'] . '</option>';
                        }
                    } else {
                        echo '<option value="" disabled>Tidak ada kategori tersedia</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="tingkat" class="form-label">Tingkat</label>
                <input type="text" class="form-control" name="tingkat" id="tingkat" placeholder="Tingkat">
            </div>
            <div class="col-md-4">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="batas_bawah" class="form-label">Batas Bawah (m3)</label>
                <input type="text" class="form-control" name="batas_bawah" id="batas_bawah"
                    placeholder="Batas Bawah (m3)">
            </div>
            <div class="col-md-4">
                <label for="batas_atas" class="form-label">Batas Atas (m3)</label>
                <input type="text" class="form-control" name="batas_atas" id="batas_atas" placeholder="Batas Atas (m3)">
            </div>
            <div class="col-md-4">
                <label for="harga_per_m3" class="form-label">Harga (m3)</label>
                <input type="text" class="form-control" name="harga_per_m3" id="harga_per_m3" placeholder="Harga (m3)">
            </div>

        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>
<script>
    $("#tambah-tarif").submit(function (e) {
        var formData = new FormData(this);

        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "modules/proses-tarif.php?aksi=tambah-tarif",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == "ok") {
                    loadTable();
                    $('.modal').modal('hide');
                    alertify.success('Tarif Berhasil Ditambah');

                } else {
                    alertify.error('Tarif Gagal Ditambah');

                }
            }
        });
    });
</script>