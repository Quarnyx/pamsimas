<?php
require_once('../modules/config.php');
switch ($_GET['aksi'] ?? '') {
    case 'tambah-tarif':
        $kategori_id = $_POST['kategori_id'];
        $tingkat = $_POST['tingkat'];
        $batas_bawah = $_POST['batas_bawah'];
        $batas_atas = $_POST['batas_atas'];
        $harga_per_m3 = $_POST['harga_per_m3'];
        $keterangan = $_POST['keterangan'] ?? '';
        $sql = "INSERT INTO tarif_bertingkat (kategori_id, tingkat, batas_bawah, batas_atas, harga_per_m3, keterangan) VALUES ('$kategori_id', '$tingkat', '$batas_bawah', '$batas_atas', '$harga_per_m3', '$keterangan')";
        $result = $conn->query($sql);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
            http_response_code(400);
        }
        break;
    case 'hapus-tarif':
        $id = $_POST['id'];
        $sql = "DELETE FROM tarif_bertingkat WHERE id = '$id'";
        $result = $conn->query($sql);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
            http_response_code(400);
        }
        break;
    case 'edit-tarif':
        $id = $_POST['id'];
        $kategori_id = $_POST['kategori_id'];
        $tingkat = $_POST['tingkat'];
        $batas_bawah = $_POST['batas_bawah'];
        $batas_atas = $_POST['batas_atas'];
        $harga_per_m3 = $_POST['harga_per_m3'];
        $keterangan = $_POST['keterangan'] ?? '';
        $sql = "UPDATE tarif_bertingkat SET kategori_id = '$kategori_id', tingkat = '$tingkat', batas_bawah = '$batas_bawah', batas_atas = '$batas_atas', harga_per_m3 = '$harga_per_m3', keterangan = '$keterangan' WHERE id = '$id'";
        $result = $conn->query($sql);
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