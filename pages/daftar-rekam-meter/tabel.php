<div>
    <table id="data-table" class="table table-searchable">
        <thead>
            <tr>
                <th>Tanggal Rekam</th>
                <th>Nama Pelanggan</th>
                <th>Pemakaian</th>
                <th>Bulan Tagihan</th>
                <th>Petugas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../../modules/config.php';
            $query = "SELECT * FROM vw_perekaman_meter ORDER BY id DESC";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc(($result))) {
                    ?>
                    <tr>
                        <td><?php echo $row['tanggal_catat']; ?></td>
                        <td><?php echo $row['nama_pelanggan']; ?></td>
                        <td><?php echo $row['pemakaian']; ?></td>
                        <td><?php echo date('F', strtotime($row['periode_tahun'] . '-' . $row['periode_bulan'] . '-01')); ?>
                        </td>
                        <td><?php echo $row['nama_lengkap']; ?></td>
                        <td>
                            <button id="edit" class="btn btn-sm btn-info" data-nama="<?= $row['nama_pelanggan'] ?>"
                                data-id="<?= $row['id'] ?>">Info Detail</button>
                            <button id="delete" class="btn btn-sm btn-danger" data-nama="<?= $row['nama_pelanggan'] ?>"
                                data-id="<?= $row['id'] ?>">Hapus</button>
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
        $('#data-table').on('click', '#edit', function () {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            $.ajax({
                type: 'POST',
                url: 'pages/daftar-rekam-meter/form-edit.php',
                data: 'id=' + id + '&nama=' + nama,
                success: function (data) {
                    $('.modal').modal('show');
                    $('.modal-title').html('Detail ' + nama);
                    $('.modal .modal-body').html(data);
                }
            })
        });
        $('#data-table').on('click', '#delete', function () {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            alertify.confirm('Hapus', 'Apakah anda yakin ingin menghapus data ' + nama + '?, data tagihan akan ikut terhapus', function () {
                $.ajax({
                    type: 'POST',
                    url: 'modules/proses-daftar-rekam-meter.php?aksi=hapus-daftar-rekam-meter',
                    data: 'id=' + id,
                    success: function (data) {
                        if (data == "ok") {
                            loadTable();
                            $('.modal').modal('hide');
                            alertify.success('Data Berhasil Dihapus');

                        } else {
                            alertify.error('Data Gagal Dihapus');

                        }
                    },
                    error: function (data) {
                        alertify.error(data);
                    }
                })
            }, function () {
                alertify.error('Hapus dibatalkan');
            })
        });
    });
</script>