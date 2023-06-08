<?php

include 'C:/AcessoLinear/www/htdocs/z/config.php';

session_start();

$id_admin = $_SESSION['id_admin'];
$tp_admin = $_SESSION['tp_admin'];
$admin = $_SESSION['ADMTOTAL'];
$linear = $_SESSION['LINEAR'];

if ($id_admin == NULL || (($admin == NULL || $admin == 0) && ($linear == NULL || $linear == 0))) {
    header("location: ./login.php");
    exit;
}