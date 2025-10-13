<?php
$title = 'Jenis Pengeluaran'; // set the variable before including
include 'partials/page-title.php';
?>
<div class="row">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Jenis Pengeluaran</h5>
            <p class="card-subtitle">Tabel menampilkan data jenis pengeluaran di aplikasi
            </p>
            <button id="tambah" class="btn btn-primary mb-2 mt-2">Tambah
                Jenis Pengeluaran</button>
        </div>
        <div class="card-body">
            <div id="tabel">

            </div>
        </div>
    </div>

</div>
<script>
    function loadTable() {
        $('#tabel').load('pages/jenis-pengeluaran/tabel.php');
    }
    $(document).ready(function () {
        loadTable();
        $('#tambah').click(function () {
            $('.modal').modal('show');
            $('.modal-title').text('Tambah Jenis Pengeluaran');
            $('.modal-body').load('pages/jenis-pengeluaran/form-tambah.php');
        });
    });
</script>