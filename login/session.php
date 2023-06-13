<?php
$dirino= $_SERVER["DOCUMENT_ROOT"];
$dirino=$dirino.'\z\config.php';
require $dirino;

session_start();

$id_admin = $_SESSION['id_admin'];
$tp_admin = $_SESSION['tp_admin'];
$admin = $_SESSION['ADMTOTAL'];
$linear = $_SESSION['LINEAR'];

if ($id_admin == NULL || (($admin == NULL || $admin == 0) && ($linear == NULL || $linear == 0))) {
    header("location: ./login.php");
    exit;
}