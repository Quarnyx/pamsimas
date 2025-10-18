<?php
$title = 'Pembayaran Tagihan'; // set the variable before including
include 'partials/page-title.php';
include 'modules/config.php';
$counterLunas = "SELECT COUNT(*) AS total_lunas FROM tagihan WHERE status_pembayaran = 'lunas'";
$resultLunas = $conn->query($counterLunas);
$counterBelumLunas = "SELECT COUNT(*) AS total_belum_lunas FROM tagihan WHERE status_pembayaran = 'belum_bayar'";
$resultBelumLunas = $conn->query($counterBelumLunas);
?>
<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="avatar-md bg-primary bg-opacity-10 rounded-circle">
                            <iconify-icon icon="solar:archive-check-broken"
                                class="fs-32 text-primary avatar-title"></iconify-icon>
                        </div>
                    </div>
                    <div class="col-8">
                        <p class="text-muted mb-0 text-truncate">Tagihan Lunas</p>
                        <h3 class="text-dark mt-2 mb-0"><?php echo $resultLunas->fetch_assoc()['total_lunas']; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="avatar-md bg-danger bg-opacity-10 rounded-circle">
                            <iconify-icon icon="solar:map-point-remove-broken"
                                class="fs-32 text-danger avatar-title"></iconify-icon>
                        </div>
                    </div>
                    <div class="col-8">
                        <p class="text-muted mb-0 text-truncate">Tagihan Belum Lunas</p>
                        <h3 class="text-dark mt-2 mb-0">
                            <?php echo $resultBelumLunas->fetch_assoc()['total_belum_lunas']; ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Pembayaran Tagihan</h5>
            <p class="card-subtitle">Tabel menampilkan data pembayaran tagihan pelanggan di aplikasi
            </p>
        </div>
        <div class="card-body">
            <div id="tabel">

            </div>
        </div>
    </div>

</div>
<script>
    function loadTable() {
        $('#tabel').load('pages/pembayaran-tagihan/tabel.php');
    }
    $(document).ready(function () {
        loadTable();
    });
</script>