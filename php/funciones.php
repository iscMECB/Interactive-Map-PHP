<?php
function infoNacional($db)
{
    $sql = "SELECT COUNT(p.Nombre) as 'Votos', p.Nombre as 'Postulante', p.Apellidos as 'Apellido', pa.nombrePartido as 'Partido'
    FROM postulante p
    INNER JOIN votacion v ON v.idPostulanteNacional = p.IdPostulante
    INNER JOIN partido pa ON pa.idPartido = p.idPartido
    WHERE p.Estado = 'Mexico'
    GROUP BY idPostulanteNacional
    ORDER BY p.nombre ASC
    LIMIT 3";

    $entradas = mysqli_query($db, $sql);

    $resultado = array();
    $resultado = $entradas;
    return $resultado;
}


function votosTotales($db, $cuales)
{
    $sql = "SELECT COUNT(p.Nombre) as 'Votos' 
    FROM postulante p
    INNER JOIN votacion v ON v.idPostulante$cuales = p.IdPostulante";

    if ($cuales === "Nacional") {
        $sql .= "  WHERE p.Estado = 'Mexico'";
    }

    if ($cuales === "Estatal") {
        $sql .= "  WHERE p.Estado = 'Michoacan'";
    }

    $entradas = mysqli_query($db, $sql);
    $votos = null;

    while ($entrada = mysqli_fetch_assoc($entradas)) :
        $votos = $entrada['Votos'];
    endwhile;

    $votosNacionales = intval($votos);

    return $votosNacionales;
}

function infoEstatal($db)
{
    $sql = "SELECT COUNT(p.Nombre) as 'Votos', p.Nombre as 'Postulante', p.Apellidos as 'Apellido', pa.nombrePartido as 'Partido'
    FROM postulante p
    INNER JOIN votacion v ON v.idPostulanteEstatal = p.IdPostulante
    INNER JOIN partido pa ON pa.idPartido = p.idPartido
    WHERE p.Estado = 'Michoacan'
    GROUP BY idPostulanteEstatal
    ORDER BY p.nombre ASC
    LIMIT 3";

    $entradas = mysqli_query($db, $sql);

    $resultado = array();
    $resultado = $entradas;
    return $resultado;
}

function infoMunicipal($db)
{
    $sql = "SELECT COUNT(p.Nombre) as 'Votos', p.Nombre as 'Postulante', pa.nombrePartido as 'Partido'
    FROM postulante p
    INNER JOIN votacion v ON v.idPostulanteMunicipal = p.IdPostulante
    INNER JOIN partido pa ON pa.idPartido = p.idPartido
    WHERE p.Municipio = 'Uruapan'
    GROUP BY idPostulanteMunicipal
    ORDER BY p.nombre ASC
    LIMIT 3";

    $entradas = mysqli_query($db, $sql);

    $resultado = array();
    $resultado = $entradas;
    return $resultado;
}
