<?php

if (file_exists(__DIR__ . '/../models/metricas.php')) {
    require_once __DIR__ . '/../models/metricas.php';
} else {
    require_once __DIR__ . '/../models/Metricas.php';
}

function get_metricas()
{
    return [
        'usuarios'          => Metricas::get_total_usuarios(),
        'estudiantes'       => Metricas::get_total_estudiantes(),
        'cursos'            => Metricas::get_total_cursos(),
        'escuelas'          => Metricas::get_total_escuelas(),
        'profesores'        => Metricas::get_total_profesores(),
        'matriculados_anio' => Metricas::get_cursos_matriculados_anio(),
        'cursos_por_estado' => Metricas::get_cursos_por_estado(),
    ];
}


function get_total_usuarios()
{
    return Metricas::get_total_usuarios();
}

function get_total_estudiantes()
{
    return Metricas::get_total_estudiantes();
}

function get_total_cursos()
{
    return Metricas::get_total_cursos();
}

function get_total_escuelas()
{
    return Metricas::get_total_escuelas();
}

function get_total_profesores()
{
    return Metricas::get_total_profesores();
}

function get_cursos_matriculados_anio()
{
    return Metricas::get_cursos_matriculados_anio();
}

function get_cursos_por_estado()
{
    return Metricas::get_cursos_por_estado();
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {

    if ($_GET['action'] === 'metricas-json') {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(get_metricas());
        exit();
    }
}
