<?php
include '../../modules/config.php';
$sql = "SELECT * FROM pelanggan WHERE id = '$_POST[id]'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>
<form id="form-edit" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <div class="d-grid gap-3">
        <div class="row">
            <div class="col-md-6">
                <label for="nama" class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control" name="nama_pelanggan" id="nama" placeholder="Nama Pelanggan"
                    value="<?= $row['nama_pelanggan'] ?>">
            </div>
            <div class="col-md-6">
                <label for="no_telp" class="form-label">No. Telp</label>
                <input type="text" class="form-control" name="no_telepon" id="no_telp" placeholder="No. Telp"
                    value="<?= $row['no_telepon'] ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="wilayah" class="form-label">Wilayah</label>
                <?php
                require_once '../../modules/config.php';
                $takeWilayah = "SELECT * FROM wilayah";
                $resultWilayah = mysqli_query($conn, $takeWilayah);
                ?>
                <select class="form-select" name="wilayah_id" id="wilayah">
                    <option value="" selected disabled>-- Pilih Wilayah --</option>
                    <?php
                    if ($resultWilayah && mysqli_num_rows($resultWilayah) > 0) {
                        while ($rowWilayah = mysqli_fetch_assoc($resultWilayah)) {
                            echo '<option value="' . $rowWilayah['id'] . '"' . ($rowWilayah['id'] == $row['wilayah_id'] ? ' selected' : '') . '>' . $rowWilayah['nama_wilayah'] . ' RT ' . $rowWilayah['rt'] . ' RW ' . $rowWilayah['rw'] . '</option>';
                        }
                    } else {
                        echo '<option value="" disabled>Tidak ada wilayah tersedia</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="kategori" class="form-label">Kategori</label>
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
                <label for="no_meter" class="form-label">No. Meter</label>
                <input type="text" class="form-control" name="no_meter" id="no_meter" placeholder="No. Meter"
                    value="<?= $row['no_meter'] ?>">
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" name="alamat" id="alamat" rows="3"
                    placeholder="Alamat"><?= $row['alamat'] ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="tanggal_registrasi" class="form-label">Tanggal Registrasi</label>
                <input type="date" class="form-control" name="tanggal_registrasi" id="tanggal_registrasi"
                    placeholder="Tanggal Registrasi" value="<?= $row['tanggal_registrasi'] ?>">
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
            url: 'modules/proses-pelanggan.php?aksi=edit-pelanggan',
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