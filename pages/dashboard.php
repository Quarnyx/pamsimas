<?php
$title = 'Dashboard'; // set the variable before including
include __DIR__ . '/../partials/page-title.php';
include 'modules/config.php';
$counterLunas = "SELECT COUNT(*) AS total_lunas FROM tagihan WHERE status_pembayaran = 'lunas'";
$resultLunas = $conn->query($counterLunas);
$counterBelumLunas = "SELECT COUNT(*) AS total_belum_lunas FROM tagihan WHERE status_pembayaran = 'belum_bayar'";
$resultBelumLunas = $conn->query($counterBelumLunas);
$countJumlahPelanggan = "SELECT COUNT(*) AS total_pelanggan FROM pelanggan";
$resultJumlahPelanggan = $conn->query($countJumlahPelanggan);
$sumPendapatan = "SELECT SUM(jumlah_bayar) AS total_pendapatan FROM pembayaran";
$resultPendapatan = $conn->query($sumPendapatan);
?>
<div class="row">
    <!-- Card 1 -->
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-md bg-primary bg-opacity-10 rounded-circle">
                            <iconify-icon icon="solar:globus-outline"
                                class="fs-32 text-primary avatar-title"></iconify-icon>
                        </div>
                    </div>
                    <div class="col-6 text-end">
                        <p class="text-muted mb-0 text-truncate">Pelanggan</p>
                        <h3 class="text-dark mt-2 mb-0"><?= $resultJumlahPelanggan->fetch_assoc()['total_pelanggan'] ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0 py-2 bg-light bg-opacity-50 mx-2 mb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted ms-1 fs-12">Total Pelanggan Terdaftar</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-md bg-primary bg-opacity-10 rounded-circle">
                            <iconify-icon icon="solar:bag-check-outline"
                                class="fs-32 text-primary avatar-title"></iconify-icon>
                        </div>
                    </div>
                    <div class="col-6 text-end">
                        <p class="text-muted mb-0 text-truncate">Tagihan Lunas</p>
                        <h3 class="text-dark mt-2 mb-0"><?= $resultLunas->fetch_assoc()['total_lunas'] ?></h3>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0 py-2 bg-light bg-opacity-50 mx-2 mb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted ms-1 fs-12">Total Tagihan Lunas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-md bg-danger bg-opacity-10 rounded-circle">
                            <iconify-icon icon="solar:map-point-remove-broken"
                                class="fs-32 text-danger avatar-title"></iconify-icon>
                        </div>
                    </div>
                    <div class="col-6 text-end">
                        <p class="text-muted mb-0 text-truncate">Tagihan Belum Lunas</p>
                        <h3 class="text-dark mt-2 mb-0"><?= $resultBelumLunas->fetch_assoc()['total_belum_lunas'] ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0 py-2 bg-light bg-opacity-50 mx-2 mb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted ms-1 fs-12">Total Tagihan Belum Lunas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="avatar-md bg-primary bg-opacity-10 rounded-circle">
                            <iconify-icon icon="solar:users-group-two-rounded-outline"
                                class="fs-32 text-primary avatar-title"></iconify-icon>
                        </div>
                    </div>
                    <div class="col-9 text-end">
                        <p class="text-muted mb-0 text-truncate">Total Pendapatan</p>
                        <h3 class="text-dark mt-2 mb-0">
                            <?= number_format($resultPendapatan->fetch_assoc()['total_pendapatan'], 0) ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0 py-2 bg-light bg-opacity-50 mx-2 mb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted ms-1 fs-12">Total Pendapatan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card card-height-100">
            <div class="card-header d-flex align-items-center justify-content-between gap-2">
                <h4 class="card-title flex-grow-1">Grafik Pendapatan dan Pengeluaran</h4>

            </div>

            <div class="card-body pt-0">
                <div dir="ltr">
                    <div id="dash-performance-chart" class="apex-charts"></div>
                </div>
            </div>

        </div> <!-- end card-->
    </div> <!-- end col -->
</div> <!-- End row -->

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Pembayaran Terbaru</h4>

                    <a href="?page=pembayaran-tagihan" class="btn btn-sm btn-primary">
                        <i class="bx bx-plus me-1"></i>Pembayaran Tagihan
                    </a>
                </div>
            </div> <!-- end card body -->
            <div class="table-responsive table-centered">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Tanggal Tagihan</th>
                            <th>Tanggal Jatuh Tempo</th>
                            <th>Kode Pelanggan</th>
                            <th>Nama Pelanggan</th>
                            <th>Pemakaian</th>
                            <th>Bulan Tagihan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM vw_tagihan ORDER BY id DESC LIMIT 5";
                        $result = mysqli_query($conn, $query);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc(($result))) {
                                ?>
                                <tr>
                                    <td>
                                        <?php
                                        if ($row['status_pembayaran'] == 'lunas') {
                                            echo '<span class="badge bg-success">Lunas</span>';
                                        } else {
                                            echo '<span class="badge bg-danger">Belum Lunas</span>';
                                        }
                                        ?>
                                    <td><?php echo $row['tanggal_tagihan']; ?></td>
                                    <td><?php echo $row['tanggal_jatuh_tempo']; ?></td>
                                    <td><?php echo $row['kode_pelanggan']; ?></td>
                                    <td><?php echo $row['nama_pelanggan']; ?></td>
                                    <td><?php echo $row['pemakaian']; ?></td>
                                    <td><?php echo date('F', strtotime($row['periode_tahun'] . '-' . $row['periode_bulan'] . '-01')); ?>
                                        -
                                        <?php echo $row['periode_tahun']; ?>
                                    </td>
                                    <td><?php echo number_format($row['total_tagihan'], 0, ',', '.'); ?></td>

                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='5'>No data found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table> <!-- end table -->
            </div> <!-- table responsive -->

        </div> <!-- end card -->
    </div> <!-- end col -->
</div> <!-- end row -->

<?php
$sqlpemasukan = "SELECT
                YEAR(tanggal) AS year,
                MONTH(tanggal) AS month,
                SUM(jumlah_bayar) AS total_pemasukan
            FROM
	            vw_laporan_pemasukan
                WHERE YEAR(tanggal) = YEAR(CURDATE())
            GROUP BY year, month";
$sqlpengeluaran = "SELECT
                YEAR(tanggal) AS year,
                MONTH(tanggal) AS month,
                SUM(jumlah) AS total_pengeluaran
            FROM
                vw_laporan_pengeluaran
                WHERE YEAR(tanggal) = YEAR(CURDATE())
            GROUP BY year, month";

$hasilpemasukan = $conn->query($sqlpemasukan);
$data_pemasukan = [];

if ($hasilpemasukan->num_rows > 0) {
    while ($row = $hasilpemasukan->fetch_assoc()) {
        $data_pemasukan[] = $row;
    }
}

$hasilpengeluaran = $conn->query($sqlpengeluaran);
$data_pengeluaran = [];

if ($hasilpengeluaran->num_rows > 0) {
    while ($row = $hasilpengeluaran->fetch_assoc()) {
        $data_pengeluaran[] = $row;
    }
}

// Preparing data for ApexCharts
$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
$array_pemasukan = array_fill(0, 12, 0);
$array_pengeluaran = array_fill(0, 12, 0);

// Map buys data to corresponding months
foreach ($data_pengeluaran as $data) {
    $array_pengeluaran[$data['month'] - 1] = $data['total_pengeluaran'];
}
// Map sales data to corresponding months
foreach ($data_pemasukan as $data) {
    $array_pemasukan[$data['month'] - 1] = $data['total_pemasukan'];
}

$conn->close();
?>
<script>
    var options = {
        series: [
            {
                name: "Pemasukan",
                type: "area",
                data: <?php echo json_encode($array_pemasukan); ?>,
            },
            {
                name: "Pengeluaran",
                type: "area",
                data: <?php echo json_encode($array_pengeluaran); ?>,
            },
        ],
        chart: { height: 313, type: "line", toolbar: { show: !1 } },
        stroke: { dashArray: [0, 0, 2], width: [0, 2, 2], curve: "smooth" },
        fill: {
            opacity: [1, 1, 1],
            type: ["gradient", "gradient"],
            gradient: {
                type: "vertical",
                inverseColors: !1,
                opacityFrom: 0.5,
                opacityTo: 0,
                stops: [0, 90],
            },
        },
        markers: { size: [0, 0], strokeWidth: 2, hover: { size: 4 } },
        xaxis: {
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
            axisTicks: { show: !1 },
            axisBorder: { show: !1 },
        },
        yaxis: { min: 0, axisBorder: { show: !1 } },
        grid: {
            show: !0,
            strokeDashArray: 3,
            xaxis: { lines: { show: !1 } },
            yaxis: { lines: { show: !0 } },
            padding: { top: 0, right: -2, bottom: 0, left: 10 },
        },
        legend: {
            show: !0,
            horizontalAlign: "center",
            offsetX: 0,
            offsetY: 5,
            markers: { width: 9, height: 9, radius: 6 },
            itemMargin: { horizontal: 10, vertical: 0 },
        },
        plotOptions: {
            bar: { columnWidth: "30%", barHeight: "70%", borderRadius: 3 },
        },
        colors: ["#17c553", "#7942ed"],
        tooltip: {
            shared: !0,
            y: [
                {
                    formatter: function (e) {
                        return void 0 !== e ? `Rp ${e.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')}` : e;
                    },
                },
                {
                    formatter: function (e) {
                        return void 0 !== e ? `Rp ${e.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')}` : e;
                    },
                },
            ],
        },
    },
        chart = new ApexCharts(
            document.querySelector("#dash-performance-chart"),
            options
        );
    chart.render();


</script>