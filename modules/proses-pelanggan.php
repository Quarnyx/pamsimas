<?php
require_once('../modules/config.php');
switch ($_GET['aksi'] ?? '') {
    case 'tambah-pelanggan':
        // Kode pelanggan 5 angka acak
        $kode_pelanggan = rand(10000, 99999);
        $nama_pelanggan = $_POST['nama_pelanggan'];
        $alamat = $_POST['alamat'];
        $no_telepon = $_POST['no_telepon'];
        $no_meter = $_POST['no_meter'];
        $kategori_id = $_POST['kategori_id'];
        $wilayah_id = $_POST['wilayah_id'];
        $tanggal_registrasi = $_POST['tanggal_registrasi'];
        $sql = "INSERT INTO pelanggan (kode_pelanggan, nama_pelanggan, alamat, no_telepon, no_meter, kategori_id, wilayah_id, tanggal_registrasi) VALUES ('$kode_pelanggan', '$nama_pelanggan', '$alamat', '$no_telepon', '$no_meter', '$kategori_id', '$wilayah_id', '$tanggal_registrasi')";
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
    case 'hapus-pelanggan':
        $id = $_POST['id'];
        $sql = "DELETE FROM pelanggan WHERE id = '$id'";
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
    case 'edit-pelanggan':
        $id = $_POST['id'];
        $nama_pelanggan = $_POST['nama_pelanggan'];
        $alamat = $_POST['alamat'];
        $no_telepon = $_POST['no_telepon'];
        $no_meter = $_POST['no_meter'];
        $kategori_id = $_POST['kategori_id'];
        $wilayah_id = $_POST['wilayah_id'];
        $tanggal_registrasi = $_POST['tanggal_registrasi'];
        $sql = "UPDATE pelanggan SET nama_pelanggan = '$nama_pelanggan', alamat = '$alamat', no_telepon = '$no_telepon', no_meter = '$no_meter', kategori_id = '$kategori_id', wilayah_id = '$wilayah_id', tanggal_registrasi = '$tanggal_registrasi' WHERE id = '$id'";
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