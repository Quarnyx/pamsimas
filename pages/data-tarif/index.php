<?php
$title = 'Data Tarif'; // set the variable before including
include 'partials/page-title.php';
?>
<div class="row">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Data Tarif</h5>
            <p class="card-subtitle">Tabel menampilkan data tarif pelanggan di aplikasi
            </p>
            <button id="tambah" class="btn btn-primary mb-2 mt-2">Tambah
                Tarif</button>
        </div>
        <div class="card-body">
            <div id="tabel">

            </div>
        </div>
    </div>

</div>
<script>
    function loadTable() {
        $('#tabel').load('pages/data-tarif/tabel.php');
    }
    $(document).ready(function () {
        loadTable();
        $('#tambah').click(function () {
            $('.modal').modal('show');
            $('.modal-title').text('Tambah Tarif');
            $('.modal-body').load('pages/data-tarif/form-tambah.php');
        });
    });
</script>