<?php

require_once 'conexion.php';

$claveEl = $_GET['claveElector'];


$sql = "SELECT Celular FROM persona WHERE Clave_elector = '$claveEl'";
$entradas = mysqli_query($db, $sql);

$celular = null;
while ($entrada = mysqli_fetch_assoc($entradas)) :
    $celular = $entrada['Celular'];
endwhile;

var_dump($celular);

/* $claveEl = $_GET['claveElector'];

$sql = "SELECT Celular FROM persona WHERE Clave_elector = '$claveEl'";
$entradas = mysqli_query($db, $sql);

$celular = null;
while ($entrada = mysqli_fetch_assoc($entradas)) :
    $celular = $entrada['Celular'];
endwhile;

var_dump($celular); */
