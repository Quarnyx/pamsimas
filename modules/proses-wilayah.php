<?php
require_once('../modules/config.php');
switch ($_GET['aksi'] ?? '') {
    case 'tambah-wilayah':
        $nama_wilayah = $_POST['nama_wilayah'];
        $rt = $_POST['rt'];
        $rw = $_POST['rw'];
        $keterangan = $_POST['keterangan'] ?? '';
        $kode_wilayah = $rt . $rw;
        $sql = "INSERT INTO wilayah (kode_wilayah, nama_wilayah, rt, rw, keterangan) VALUES ('$kode_wilayah', '$nama_wilayah', '$rt', '$rw', '$keterangan')";
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
    case 'hapus-wilayah':
        $id = $_POST['id'];
        $sql = "DELETE FROM wilayah WHERE id = '$id'";
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
    case 'edit-wilayah':
        $id = $_POST['id'];
        $nama_wilayah = $_POST['nama_wilayah'];
        $rt = $_POST['rt'];
        $rw = $_POST['rw'];
        $keterangan = $_POST['keterangan'] ?? '';
        $kode_wilayah = $rt . $rw;
        $sql = "UPDATE wilayah SET kode_wilayah = '$kode_wilayah', nama_wilayah = '$nama_wilayah', rt = '$rt', rw = '$rw', keterangan = '$keterangan' WHERE id = '$id'";
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