<div>
    <table id="data-table" class="table table-searchable">
        <thead>
            <tr>
                <th>Kode Pelanggan</th>
                <th>Nama Pelanggan</th>
                <th>Kategori</th>
                <th>Alamat</th>
                <th>No Telp</th>
                <th>No Meter</th>
                <th>Status</th>
                <th>Registrasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../../modules/config.php';
            $query = "SELECT
                        pelanggan.*,
                        wilayah.rt,
                        wilayah.rw,
                        wilayah.nama_wilayah,
                        kategori_pelanggan.nama_kategori 
                    FROM
                        pelanggan
                        INNER JOIN wilayah ON pelanggan.wilayah_id = wilayah.id
                        INNER JOIN kategori_pelanggan ON pelanggan.kategori_id = kategori_pelanggan.id";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc(($result))) {
                    ?>
                    <tr>
                        <td><?= $row['kode_pelanggan']; ?></td>
                        <td><?= $row['nama_pelanggan']; ?></td>
                        <td><?= $row['nama_kategori']; ?></td>
                        <td><?= $row['alamat'] . ', RT ' . $row['rt'] . ', RW ' . $row['rw'] . ', ' . $row['nama_wilayah']; ?>
                        </td>
                        <td><?= $row['no_telepon']; ?></td>
                        <td><?= $row['no_meter']; ?></td>
                        <td><?= $row['status']; ?></td>
                        <td><?= $row['tanggal_registrasi']; ?></td>
                        <td>
                            <button id="edit" class="btn btn-sm btn-warning" data-nama="<?= $row['nama_pelanggan'] ?>"
                                data-id="<?= $row['id'] ?>">Edit</button>
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
                responsive: true
            }
        );
        $('#data-table').on('click', '#edit', function () {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            $.ajax({
                type: 'POST',
                url: 'pages/data-pelanggan/form-edit.php',
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
                    url: 'modules/proses-pelanggan.php?aksi=hapus-pelanggan',
                    data: 'id=' + id,
                    success: function (data) {
                        if (data == "ok") {
                            loadTable();
                            $('.modal').modal('hide');
                            alertify.success('Pelanggan Berhasil Dihapus');

                        } else {
                            alertify.error('Pelanggan Gagal Dihapus');

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