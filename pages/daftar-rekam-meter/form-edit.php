<?php
include '../../modules/config.php';
$sql = "SELECT * FROM vw_perekaman_meter WHERE id = '$_POST[id]'";
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
                    value="<?= $row['nama_pelanggan'] ?>" readonly>
            </div>
            <div class="col-md-6">
                <label for="kode" class="form-label">No Meter</label>
                <input type="text" class="form-control" name="no_meter" id="kode" value="<?= $row['no_meter'] ?>"
                    readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="deskripsi" class="form-label">Alamat</label>
                <textarea class="form-control" name="alamat" id="deskripsi" placeholder="Alamat"
                    readonly><?= $row['alamat'] ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label for="meter-awal" class="form-label">Meter Awal</label>
                <input type="text" class="form-control" name="meter_awal" id="meter-awal"
                    value="<?= $row['meter_awal'] ?>" readonly>
            </div>
            <div class="col-md-3">
                <label for="meter-akhir" class="form-label">Meter Akhir</label>
                <input type="text" class="form-control" name="meter_akhir" id="meter-akhir"
                    value="<?= $row['meter_akhir'] ?>" readonly>
            </div>
            <div class="col-md-3">
                <label for="pemakaian" class="form-label">Pemakaian (m3)</label>
                <input type="text" class="form-control" name="pemakaian" id="pemakaian" value="<?= $row['pemakaian'] ?>"
                    readonly>
            </div>
            <div class="col-md-3">
                <label for="bulan-tagihan" class="form-label">Bulan Tagihan</label>
                <input type="text" class="form-control" name="bulan_tagihan" id="bulan-tagihan"
                    value="<?= date('F Y', strtotime($row['periode_tahun'] . '-' . $row['periode_bulan'] . '-01')) ?>"
                    readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <img src="<?= $row['foto_meter'] ?>" alt="Foto Meter" class="img-fluid">
            </div>
            <div class="col-md-4">
                <label for="petugas" class="form-label">Petugas</label>
                <input type="text" class="form-control" name="petugas" id="petugas" value="<?= $row['nama_lengkap'] ?>"
                    readonly>
            </div>
            <div class="col-md-4">
                <label for="tanggal-catat" class="form-label">Tanggal Catat</label>
                <input type="text" class="form-control" name="tanggal_catat" id="tanggal-catat"
                    value="<?= $row['tanggal_catat'] ?>" readonly>
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