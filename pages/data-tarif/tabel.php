<div>
    <table id="data-table" class="table table-searchable">
        <thead>
            <tr>
                <th>Kode Kategori</th>
                <th>Nama Kategori</th>
                <th>Tingkat</th>
                <th>Batas Bawah (m3)</th>
                <th>Batas Atas (m3)</th>
                <th>Harga (m3)</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../../modules/config.php';
            $query = "SELECT
                        tarif_bertingkat.*, 
                        kategori_pelanggan.kode_kategori, 
                        kategori_pelanggan.nama_kategori
                    FROM
                        tarif_bertingkat
                        INNER JOIN
                        kategori_pelanggan
                        ON 
                            tarif_bertingkat.kategori_id = kategori_pelanggan.id ORDER BY id DESC";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc(($result))) {
                    ?>
                    <tr>
                        <td><?php echo $row['kode_kategori']; ?></td>
                        <td><?php echo $row['nama_kategori']; ?></td>
                        <td><?php echo $row['tingkat']; ?></td>
                        <td><?php echo $row['batas_bawah']; ?></td>
                        <td><?php echo $row['batas_atas']; ?></td>
                        <td><?php echo number_format($row['harga_per_m3'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['keterangan']; ?></td>
                        <td>
                            <button id="edit" class="btn btn-sm btn-warning" data-nama="<?= $row['harga_per_m3'] ?>"
                                data-id="<?= $row['id'] ?>">Edit</button>
                            <button id="delete" class="btn btn-sm btn-danger" data-nama="<?= $row['harga_per_m3'] ?>"
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
                url: 'pages/data-tarif/form-edit.php',
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
                    url: 'modules/proses-tarif.php?aksi=hapus-tarif',
                    data: 'id=' + id,
                    success: function (data) {
                        if (data == "ok") {
                            loadTable();
                            $('.modal').modal('hide');
                            alertify.success('Tarif Berhasil Dihapus');

                        } else {
                            alertify.error('Tarif Gagal Dihapus');

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