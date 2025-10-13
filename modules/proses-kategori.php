<?php
require_once('../modules/config.php');
switch ($_GET['aksi'] ?? '') {
    case 'tambah-kategori':
        $nama_kategori = $_POST['nama_kategori'];
        $kode_kategori = $_POST['kode_kategori'];
        $deskripsi = $_POST['deskripsi'] ?? '';
        $beban_tetap = $_POST['beban_tetap'] ?? 0;
        $sql = "INSERT INTO kategori_pelanggan (kode_kategori, nama_kategori, deskripsi, beban_tetap) VALUES ('$kode_kategori', '$nama_kategori', '$deskripsi', '$beban_tetap')";
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
    case 'hapus-kategori':
        $id = $_POST['id'];
        $sql = "DELETE FROM kategori_pelanggan WHERE id = '$id'";
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
    case 'edit-kategori':
        $id = $_POST['id'];
        $nama_kategori = $_POST['nama_kategori'];
        $kode_kategori = $_POST['kode_kategori'];
        $deskripsi = $_POST['deskripsi'] ?? '';
        $beban_tetap = $_POST['beban_tetap'] ?? 0;
        $sql = "UPDATE kategori_pelanggan SET kode_kategori = '$kode_kategori', nama_kategori = '$nama_kategori', deskripsi = '$deskripsi', beban_tetap = '$beban_tetap' WHERE id = '$id'";
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