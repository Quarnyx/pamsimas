<?php
require_once('../modules/config.php');
switch ($_GET['aksi'] ?? '') {
    case 'tambah-transaksi-pengeluaran':
        $kategori_pengeluaran_id = $_POST['kategori_pengeluaran'];
        $jumlah = $_POST['jumlah'];
        $tanggal_pengeluaran = $_POST['tanggal_pengeluaran'];
        $penerima = $_POST['penerima'];
        $deskripsi = $_POST['deskripsi'] ?? '';
        $status = 'approved';
        $user_id = $_POST['user_id'];
        //generate no_pengeluaran
        $sql = "SELECT no_pengeluaran FROM pengeluaran ORDER BY no_pengeluaran DESC LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $lastNo = $row['no_pengeluaran'];
            $lastNumber = (int) substr($lastNo, 3);
            $newNumber = $lastNumber + 1;
            $newNo = 'EXP' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
        } else {
            $newNo = 'EXP000001';
        }
        $sql = "INSERT INTO pengeluaran (no_pengeluaran, kategori_pengeluaran_id, jumlah, tanggal_pengeluaran, penerima, deskripsi, status, diinput_oleh) VALUES ('$newNo', '$kategori_pengeluaran_id', '$jumlah', '$tanggal_pengeluaran', '$penerima', '$deskripsi', '$status', '$user_id')";
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
    case 'hapus-transaksi-pengeluaran':
        $id = $_POST['id'];
        $sql = "DELETE FROM pengeluaran WHERE id = '$id'";
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
    case 'edit-transaksi-pengeluaran':
        $id = $_POST['id'];
        $kategori_pengeluaran_id = $_POST['kategori_pengeluaran'];
        $jumlah = $_POST['jumlah'];
        $tanggal_pengeluaran = $_POST['tanggal_pengeluaran'];
        $penerima = $_POST['penerima'];
        $deskripsi = $_POST['deskripsi'] ?? '';
        $sql = "UPDATE pengeluaran SET kategori_pengeluaran_id = '$kategori_pengeluaran_id', jumlah = '$jumlah', tanggal_pengeluaran = '$tanggal_pengeluaran', penerima = '$penerima', deskripsi = '$deskripsi' WHERE id = '$id'";
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