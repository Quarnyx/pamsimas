<div>
    <table id="data-table" class="table table-searchable">
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
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../../modules/config.php';
            $query = "SELECT * FROM vw_tagihan ORDER BY id DESC";
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
                        <td><?php echo date('F', strtotime($row['periode_tahun'] . '-' . $row['periode_bulan'] . '-01')); ?> -
                            <?php echo $row['periode_tahun']; ?>
                        </td>
                        <td><?php echo number_format($row['total_tagihan'], 0, ',', '.'); ?></td>
                        <td>
                            <?php if ($row['status_pembayaran'] == 'lunas') {
                                ?>
                                <button class="btn btn-sm btn-success" id="cetak" data-id="<?= $row['id'] ?>"
                                    data-nama="<?= $row['nama_pelanggan'] ?>">Cetak Ulang</button>
                                <?php
                            } else {
                                ?>
                                <button id="bayar" class="btn btn-sm btn-info" data-nama="<?= $row['nama_pelanggan'] ?>"
                                    data-id="<?= $row['id'] ?>">Bayar</button>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='5'>No data found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function () {
        new DataTable('#data-table',
            {
                responsive: true,
                ordering: false
            }
        );
        $('#data-table').on('click', '#bayar', function () {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            $.ajax({
                type: 'POST',
                url: 'pages/pembayaran-tagihan/form-bayar.php',
                data: 'id=' + id + '&nama=' + nama,
                success: function (data) {
                    $('.modal').modal('show');
                    $('.modal-title').html('Detail ' + nama);
                    $('.modal .modal-body').html(data);
                }
            })
        });
        $('#data-table').on('click', '#cetak', function () {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            window.open('pages/pembayaran-tagihan/cetak-struk.php?id=' + id, '_blank');
        });
    });
</script>