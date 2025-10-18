<div>
    <table id="data-table" class="table table-searchable">
        <thead>
            <tr>
                <th>Kode Pengeluaran</th>
                <th>Tanggal</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah</th>
                <th>Penerima</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../../modules/config.php';
            $query = "SELECT * FROM vw_laporan_pengeluaran ORDER BY id DESC";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc(($result))) {
                    ?>
                    <tr>
                        <td><?php echo $row['no_pengeluaran']; ?></td>
                        <td><?php echo $row['tanggal']; ?></td>
                        <td><?php echo $row['nama_kategori']; ?></td>
                        <td><?php echo $row['deskripsi']; ?></td>
                        <td><?php echo number_format($row['jumlah'], 0, ',', '.') ?></td>
                        <td><?php echo $row['penerima']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <button id="edit" class="btn btn-sm btn-warning" data-nama="<?= $row['nama_kategori'] ?>"
                                data-id="<?= $row['id'] ?>">Edit</button>
                            <button id="delete" class="btn btn-sm btn-danger" data-nama="<?= $row['nama_kategori'] ?>"
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
                responsive: true
            }
        );
        $('#data-table').on('click', '#edit', function () {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            $.ajax({
                type: 'POST',
                url: 'pages/pengeluaran/form-edit.php',
                data: 'id=' + id + '&nama=' + nama,
                success: function (data) {
                    $('.modal').modal('show');
                    $('.modal-title').html('Edit Data ' + nama);
                    $('.modal .modal-body').html(data);
                }
            })
        });
        $('#data-table').on('click', '#delete', function () {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            alertify.confirm('Hapus', 'Apakah anda yakin ingin menghapus data ' + nama + '?', function () {
                $.ajax({
                    type: 'POST',
                    url: 'modules/proses-pengeluaran.php?aksi=hapus-transaksi-pengeluaran',
                    data: 'id=' + id,
                    success: function (data) {
                        if (data == "ok") {
                            loadTable();
                            $('.modal').modal('hide');
                            alertify.success('Transaksi Berhasil Dihapus');

                        } else {
                            alertify.error('Transaksi Gagal Dihapus');

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