<?php
session_start();

require_once 'conexion.php';
require_once 'httpPHPAltiria.php';

$claveEl = $_GET['claveElector'];
$_SESSION['clave'] = $claveEl;

$sql = "SELECT Celular FROM persona WHERE Clave_elector = '$claveEl'";
$entradas = mysqli_query($db, $sql);

$celular = null;
while ($entrada = mysqli_fetch_assoc($entradas)) :
  $celular = $entrada['Celular'];
endwhile;


$altiriaSMS = new AltiriaSMS();

$altiriaSMS->setLogin('');
$altiriaSMS->setPassword('');

$altiriaSMS->setDebug(true);

$sDestination = "$celular";

$clave = rand(100, 999);

$response = $altiriaSMS->sendSMS($sDestination, "Quedan 6 mensajes compa. Clave: $clave");


$sql2 = "UPDATE persona SET cverificacion = '$clave' WHERE Clave_elector = '$claveEl'";
$insertar = mysqli_query($db, $sql2);

echo json_encode(true);
