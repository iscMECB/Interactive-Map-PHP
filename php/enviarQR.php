<?php
session_start();

require_once 'conexion.php';
require_once "QR_BarCode.php";

$claveCifrada = $_GET['claveCifrada'];
$clave = $_SESSION['clave'];

$sql2 = "UPDATE persona SET claveqr = '$claveCifrada' WHERE Clave_elector = '$clave'";
$insertar = mysqli_query($db, $sql2);


// QR_BarCode object 
$qr = new QR_BarCode();

// create text QR code 
$qr->text($claveCifrada);

// display QR code image
echo $qr->qrCode();
