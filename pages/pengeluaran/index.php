<?php
$title = 'Transaksi Pengeluaran'; // set the variable before including
include 'partials/page-title.php';
?>
<div class="row">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Transaksi Pengeluaran</h5>
            <p class="card-subtitle">Tabel menampilkan data transaksi pengeluaran di aplikasi
            </p>
            <button id="tambah" class="btn btn-primary mb-2 mt-2">Tambah
                Transaksi Pengeluaran</button>
        </div>
        <div class="card-body">
            <div id="tabel">

            </div>
        </div>
    </div>

</div>
<script>
    function loadTable() {
        $('#tabel').load('pages/pengeluaran/tabel.php');
    }
    $(document).ready(function () {
        loadTable();
        $('#tambah').click(function () {
            $('.modal').modal('show');
            $('.modal-title').text('Tambah Transaksi Pengeluaran');
            $('.modal-body').load('pages/pengeluaran/form-tambah.php');
        });
    });
</script>