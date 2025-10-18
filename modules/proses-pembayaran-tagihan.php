<?php
require_once('../modules/config.php');
switch ($_GET['aksi'] ?? '') {
    case 'pembayaran-tagihan':
        $id = $_POST['id'];
        $jumlah_bayar = $_POST['total_tagihan'];
        $tanggal_bayar = date('Y-m-d');
        $tagihan_id = $_POST['id'];
        $kasir_id = $_POST['kasir_id'];
        $keterangan = 'Pembayaran tagihan ID ' . $tagihan_id . ' oleh kasir ID ' . $kasir_id;
        // generate kode no pembayaran
        $kode_pembayaran = 'PB-' . strtoupper(uniqid());
        $sql = "INSERT INTO pembayaran (tagihan_id, tanggal_bayar, jumlah_bayar, keterangan, no_pembayaran, kasir_id) VALUES ('$id', '$tanggal_bayar', '$jumlah_bayar', '$keterangan', '$kode_pembayaran', '$kasir_id')";
        $result = $conn->query($sql);

        // update status tagihan to 'Lunas'
        $update_tagihan = "UPDATE tagihan SET status_pembayaran = 'lunas' WHERE id = '$id'";
        $result = $conn->query($update_tagihan);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
            http_response_code(400);
        }
        break;

}