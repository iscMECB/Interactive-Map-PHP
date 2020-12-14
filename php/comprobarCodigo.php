<?php
session_start();
require_once 'conexion.php';

$clave = $_SESSION['clave'];
$codigo = $_GET['codigo'];

$sql = "SELECT cverificacion FROM persona WHERE Clave_elector = '$clave'";
$entradas = mysqli_query($db, $sql);

$codigoDB = null;
while ($entrada = mysqli_fetch_assoc($entradas)) :
    $codigoDB = $entrada['cverificacion'];
endwhile;

if ($codigo == $codigoDB) {
    echo json_encode($clave);
} else {
    echo json_encode(false);
}
