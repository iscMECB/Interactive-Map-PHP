<?php
require_once 'conexion.php';

$ciudad = $_GET['ciudad'];

$sql = "SELECT COUNT(p.Nombre) as 'Votos', p.Nombre as 'Postulante', p.Apellidos as 'Apellido', pa.nombrePartido as 'Partido'
    FROM postulante p
    INNER JOIN votacion v ON v.idPostulanteMunicipal = p.IdPostulante
    INNER JOIN partido pa ON pa.idPartido = p.idPartido
    WHERE p.Municipio = '$ciudad'
    GROUP BY idPostulanteMunicipal
    ORDER BY p.nombre ASC
    LIMIT 3";

$entradas = mysqli_query($db, $sql);

$sql2 = "SELECT COUNT(p.Nombre) as 'Votos' 
FROM postulante p
INNER JOIN votacion v ON v.idPostulanteMunicipal = p.IdPostulante
WHERE p.Municipio = '$ciudad'";

$entradas2 = mysqli_query($db, $sql2);

$votos = null;

while ($entrada2 = mysqli_fetch_assoc($entradas2)) :
  $votos = $entrada2['Votos'];
endwhile;

$votosTotales = intval($votos);

$postulantes = array();
$porcentajes = array();
$votos = array();
$partidos = array();
$datos = array();
$i = 0;

if (mysqli_num_rows($entradas) >= 1) {
  while ($entrada = mysqli_fetch_assoc($entradas)) :
    $postulantes[$i] = $entrada['Postulante'] . ' ' . $entrada['Apellido'];
    $porcentajes[$i] = round(intval($entrada['Votos']) * 100 / $votosTotales, 2);
    $votos[$i] = $entrada['Votos'];
    $partidos[$i] = $entrada['Partido'];
    $i++;
  endwhile;

  $datos['Postulante'] = $postulantes;
  $datos['Porcentaje'] = $porcentajes;
  $datos['Votos'] = $votos;
  $datos['Partido'] = $partidos;
}

echo json_encode($datos);
