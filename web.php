<?php

if (isset($_GET['page'])) {
    include 'pages/' . $_GET['page'] . '/index.php';
} else {
    include 'pages/dashboard.php';
}