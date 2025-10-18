<?php
require_once('../modules/config.php');
switch ($_GET['aksi'] ?? '') {
    case 'hapus-daftar-rekam-meter':
        $id = $_POST['id'];
        $sql = "DELETE FROM pencatatan_meter WHERE id = '$id'";
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