<?php
$servidor = '';
$usuario = '';
$password = '';
$basededatos = '';
$db = mysqli_connect($servidor, $usuario, $password, $basededatos);
mysqli_query($db, "SET NAMES 'utf8'");

/* $hostname_localhost = "";
$database_localhost = "";
$username_localhost = "";
$password_localhost = "";
$db = new mysqli($hostname_localhost, $username_localhost, $password_localhost, $database_localhost);
$conexion->set_charset("utf8"); */
