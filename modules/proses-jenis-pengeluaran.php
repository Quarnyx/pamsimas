<?php
require_once('../modules/config.php');
switch ($_GET['aksi'] ?? '') {
    case 'tambah-jenis-pengeluaran':
        $kode_kategori = $_POST['kode_kategori'];
        $nama_kategori = $_POST['nama_kategori'];
        $deskripsi = $_POST['deskripsi'] ?? '';
        $sql = "INSERT INTO kategori_pengeluaran (kode_kategori, nama_kategori, deskripsi) VALUES ('$kode_kategori', '$nama_kategori', '$deskripsi')";
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
    case 'hapus-jenis-pengeluaran':
        $id = $_POST['id'];
        $sql = "DELETE FROM kategori_pengeluaran WHERE id = '$id'";
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
    case 'edit-jenis-pengeluaran':
        $id = $_POST['id'];
        $kode_kategori = $_POST['kode_kategori'];
        $nama_kategori = $_POST['nama_kategori'];
        $deskripsi = $_POST['deskripsi'] ?? '';
        $sql = "UPDATE kategori_pengeluaran SET kode_kategori = '$kode_kategori', nama_kategori = '$nama_kategori', deskripsi = '$deskripsi' WHERE id = '$id'";
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