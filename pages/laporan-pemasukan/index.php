<?php
$title = 'Laporan Pemasukan'; // set the variable before including
include 'partials/page-title.php';
?>

<div class="row d-print-none">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Pilih Tanggal Laporan</h5>
            </div><!-- end card header -->
            <?php
            function tanggal($tanggal)
            {
                $bulan = array(
                    1 => 'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
                $split = explode('-', $tanggal);
                return $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
            }
            $daritanggal = "";
            $sampaitanggal = "";

            if (isset($_GET['dari_tanggal']) && isset($_GET['sampai_tanggal'])) {
                $daritanggal = $_GET['dari_tanggal'];
                $sampaitanggal = $_GET['sampai_tanggal'];
            }

            ?>
            <div class="card-body">
                <form action="" method="get" class="row g-3" id="laporanForm">
                    <input type="hidden" name="page" value="laporan-pemasukan">
                    <div class="col-md-6">
                        <label for="validationDefault01" class="form-label">Dari Tanggal</label>
                        <input type="date" class="form-control" id="validationDefault01" required="" name="dari_tanggal"
                            value="<?= htmlspecialchars($daritanggal) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="validationDefault02" class="form-label">Sampai Tanggal</label>
                        <input type="date" class="form-control" id="validationDefault02" required=""
                            name="sampai_tanggal" value="<?= htmlspecialchars($sampaitanggal) ?>">
                    </div>
                    <div class="col-12">
                        <small id="dateError" class="text-danger" style="display:none;">Dari Tanggal harus lebih kecil
                            dari Sampai Tanggal.</small>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary" type="submit" id="pilihBtn">Pilih</button>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div>
</div>
<!-- end row-->
<div class="row mt-3">
    <div class="col-12">
        <div class="card shadow-none">
            <div class="row">
                <div class="col-12">
                    <h4 class="text-center mt-3 "><b>PAMSIMAS</b><br><b>Laporan Pemasukan</b></h4>
                    <h6 class="text-center mb-3"><br>Periode <?php
                    if (!empty($_GET["dari_tanggal"]) && !empty($_GET["sampai_tanggal"])) {
                        echo tanggal($_GET['dari_tanggal']) . " s.d " . tanggal($_GET['sampai_tanggal']);
                    } else {
                        echo "Semua";
                    }
                    ?>
                    </h6>
                </div>
            </div>
            <hr>
            <div class="card-body">


                <table id="table-data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Periode Tagihan</th>
                            <th>No Pembayaran</th>
                            <th>Kode Pelanggan</th>
                            <th>Nama Pelanggan</th>
                            <th>Kasir</th>
                            <th>Jumlah Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once '././modules/config.php';
                        $no = 1;
                        if (empty($daritanggal) && empty($sampaitanggal)) {
                            $whereClause = "";
                        } else {
                            $whereClause = "where tanggal between '$daritanggal' and '$sampaitanggal'";
                        }
                        $sql = "SELECT * FROM vw_laporan_pemasukan $whereClause ORDER BY tanggal DESC";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= tanggal($row['tanggal']) ?></td>
                                <td><?= $row['periode'] ?></td>
                                <td><?= $row['no_pembayaran'] ?></td>
                                <td><?= $row['kode_pelanggan'] ?></td>
                                <td><?= $row['nama_pelanggan'] ?></td>
                                <td><?= $row['kasir'] ?></td>
                                <td><?= number_format($row['jumlah_bayar'], 0, ',', '.') ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="7" style="text-align:right;">Total Pemasukan:</th>
                            <th>
                                <?php
                                require_once '././modules/config.php';
                                if (empty($daritanggal) && empty($sampaitanggal)) {
                                    $whereClause = "";
                                } else {
                                    $whereClause = "where tanggal between '$daritanggal' and '$sampaitanggal'";
                                }
                                $sql = "SELECT SUM(jumlah_bayar) AS total_pemasukan FROM vw_laporan_pemasukan $whereClause";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                echo number_format($row['total_pemasukan'], 0, ',', '.');
                                ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>

                <div class="mt-4 mb-1">
                    <div class="text-end d-print-none">
                        <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i
                                class="mdi mdi-printer me-1"></i> Print</a>
                    </div>
                </div>
            </div> <!-- end card body-->

        </div> <!-- end card -->

    </div><!-- end col-->
</div>
<!-- end row-->

<script>
    (function () {
        const dariInput = document.getElementById('validationDefault01');
        const sampaiInput = document.getElementById('validationDefault02');
        const pilihBtn = document.getElementById('pilihBtn');
        const dateError = document.getElementById('dateError');
        const form = document.getElementById('laporanForm');

        function validateDates() {
            const dari = dariInput.value;
            const sampai = sampaiInput.value;

            if (!dari || !sampai) {
                dateError.style.display = 'none';
                pilihBtn.disabled = false;
                return;
            }

            const dariDate = new Date(dari);
            const sampaiDate = new Date(sampai);

            if (dariDate >= sampaiDate) {
                dateError.style.display = 'inline';
                pilihBtn.disabled = true;
            } else {
                dateError.style.display = 'none';
                pilihBtn.disabled = false;
            }
        }

        window.addEventListener('load', validateDates);
        dariInput.addEventListener('change', validateDates);
        sampaiInput.addEventListener('change', validateDates);

        form.addEventListener('submit', function (e) {
            if (pilihBtn.disabled) {
                e.preventDefault();
            }
        });
    })();
</script>