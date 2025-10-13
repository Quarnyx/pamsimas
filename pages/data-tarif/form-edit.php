<?php
include '../../modules/config.php';
$sql = "SELECT * FROM tarif_bertingkat WHERE id = '$_POST[id]'";
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
                            echo '<option value="' . $rowKategori['id'] . '" ' . ($row['kategori_id'] == $rowKategori['id'] ? 'selected' : '') . '>' . $rowKategori['nama_kategori'] . '</option>';
                        }
                    } else {
                        echo '<option value="" disabled>Tidak ada kategori tersedia</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="tingkat" class="form-label">Tingkat</label>
                <input type="text" class="form-control" name="tingkat" id="tingkat" placeholder="Tingkat"
                    value="<?= $row['tingkat'] ?>">
            </div>
            <div class="col-md-4">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan"
                    value="<?= $row['keterangan'] ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="batas_bawah" class="form-label">Batas Bawah (m3)</label>
                <input type="text" class="form-control" name="batas_bawah" id="batas_bawah"
                    placeholder="Batas Bawah (m3)" value="<?= $row['batas_bawah'] ?>">
            </div>
            <div class="col-md-4">
                <label for="batas_atas" class="form-label">Batas Atas (m3)</label>
                <input type="text" class="form-control" name="batas_atas" id="batas_atas" placeholder="Batas Atas (m3)"
                    value="<?= $row['batas_atas'] ?>">
            </div>
            <div class="col-md-4">
                <label for="harga_per_m3" class="form-label">Harga (m3)</label>
                <input type="text" class="form-control" name="harga_per_m3" id="harga_per_m3" placeholder="Harga (m3)"
                    value="<?= $row['harga_per_m3'] ?>">
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
            url: 'modules/proses-tarif.php?aksi=edit-tarif',
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