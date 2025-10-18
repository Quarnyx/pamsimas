<?php
include '../../modules/config.php';
session_start();
$sql = "SELECT * FROM vw_tagihan WHERE id = '$_POST[id]'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>
<form id="form-bayar" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <input type="hidden" name="kasir_id" value="<?= $_SESSION['user_id'] ?>">
    <div class="d-grid gap-3">
        <div class="row">
            <div class="col-md-6">
                <label for="nama" class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control" name="nama_pelanggan" id="nama" placeholder="Nama Pelanggan"
                    value="<?= $row['nama_pelanggan'] ?>" readonly>
            </div>
            <div class="col-md-6">
                <label for="kode" class="form-label">Kode Pelanggan</label>
                <input type="text" class="form-control" name="kode_pelanggan" id="kode"
                    value="<?= $row['kode_pelanggan'] ?>" readonly>
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
            <?php if (!is_null($row['foto_meter'])): ?>
                <div class="col-md-4">
                    <img src="<?= $row['foto_meter'] ?>" alt="Foto Meter" class="img-fluid">
                </div>
            <?php endif; ?>
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
        <div class="row">
            <div class="col-md-4">
                <label for="biaya-pemakaian" class="form-label">Biaya Pemakaian</label>
                <input type="text" class="form-control" name="biaya_pemakaian" id="biaya-pemakaian"
                    value="<?= $row['biaya_pemakaian'] ?>" readonly>
            </div>
            <div class="col-md-4">
                <label for="beban-tetap" class="form-label">Beban Tetap</label>
                <input type="text" class="form-control" name="beban_tetap" id="beban-tetap"
                    value="<?= $row['beban_tetap'] ?>" readonly>
            </div>
            <div class="col-md-4">
                <label for="total-tagihan" class="form-label">Total Tagihan</label>
                <input type="text" class="form-control" name="total_tagihan" id="total-tagihan"
                    value="<?= $row['total_tagihan'] ?>" readonly>
            </div>
        </div>

    </div>
    <button type="submit" class="btn btn-primary mt-3">Bayar Tagihan</button>
</form>
<script>
    $("#form-bayar").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'modules/proses-pembayaran-tagihan.php?aksi=pembayaran-tagihan',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == "ok") {
                    loadTable();
                    $('.modal').modal('hide');
                    alertify.success('Pembayaran Berhasil');

                } else {
                    alertify.error('Pembayaran Gagal');

                }
            },
            error: function (data) {
                alertify.error(data);
            }
        });
    });
</script>