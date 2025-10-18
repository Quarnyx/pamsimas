<?php
$title = 'Daftar Rekam Meter'; // set the variable before including
include 'partials/page-title.php';
?>
<div class="row">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Daftar Rekam Meter</h5>
            <p class="card-subtitle">Tabel menampilkan data rekam meter pelanggan di aplikasi
            </p>
        </div>
        <div class="card-body">
            <div id="tabel">

            </div>
        </div>
    </div>

</div>
<script>
    function loadTable() {
        $('#tabel').load('pages/daftar-rekam-meter/tabel.php');
    }
    $(document).ready(function () {
        loadTable();
    });
</script>