<?php
require_once __DIR__ . '/../models/metricas.php';

function get_metricas()
{
    $metricas = [
        'usuarios' => Metricas::get_total_usuarios(),
        'estudiantes' => Metricas::get_total_estudiantes(),
        'cursos' => Metricas::get_total_cursos(),
        'escuelas' => Metricas::get_total_escuelas(),
        'profesores' => Metricas::get_total_profesores(),
        'matriculados_anio' => Metricas::get_cursos_matriculados_anio(),
        'cursos_por_estado' => Metricas::get_cursos_por_estado()
    ];

    return $metricas;
}
?>
