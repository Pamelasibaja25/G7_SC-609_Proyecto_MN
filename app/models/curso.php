<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/config/database.php';

class Curso
{
    // 🔹 Obtener los cursos activos ("En Progreso") de un usuario
    public static function get_cursos()
    {
        global $db;
        //session_start();

        $collection = $db->Curso;
        $cursor = $collection->find([
            'estado' => 'En Progreso',
            'id_usuario' => (int)$_SESSION['usuario']
        ]);

        $cursos = [];
        foreach ($cursor as $doc) {
            $cursos[] = [
                'id_curso' => (int)$doc['_id'],
                'descripcion' => $doc['descripcion'] ?? '',
                'ruta_imagen' => $doc['ruta_imagen'] ?? ''
            ];
        }

        return $cursos;
    }

    // 🔹 Obtener un curso por su ID
    public static function get_curso($id_curso)
    {
        global $db;

        $collection = $db->Curso;
        $curso = $collection->findOne(['_id' => (int)$id_curso]);

        if ($curso) {
            return ['descripcion' => $curso['descripcion'] ?? ''];
        }
        return null;
    }

    // 🔹 Obtener los temas de un curso
    public static function get_temas_por_curso($id_curso)
    {
        global $db;

        $collection = $db->Tema;
        $cursor = $collection->find(['id_curso' => (int)$id_curso]);

        $temas = [];
        foreach ($cursor as $doc) {
            $temas[] = [
                'nombre' => $doc['nombre'] ?? '',
                'informacion' => $doc['informacion'] ?? ''
            ];
        }

        return $temas;
    }

    // 🔹 Exportar los temas de un curso a CSV
    public static function imprimir_temas($id_curso)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="Temas_Curso' . $id_curso . '.csv"');

        $temas = self::get_temas_por_curso($id_curso);
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Tema', 'Información']);

        foreach ($temas as $tema) {
            fputcsv($output, [$tema['nombre'], $tema['informacion']]);
        }

        fclose($output);
        exit;
    }

    // 🔹 Exportar reporte trimestral
    public static function imprimir_reporte()
    {
        session_start();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="Reporte_Trimestral.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Fecha Inicio', 'Fecha Final', 'Curso', 'Estado', 'Nota']);

        foreach ($_SESSION['reportes'] as $reporte) {
            fputcsv($output, [
                $reporte["fecha_inicio_trimestre"],
                $reporte["fecha_final_trimestre"],
                $reporte["descripcion"],
                $reporte["estado"],
                $reporte["nota"]
            ]);
        }

        fclose($output);
        exit;
    }

    // 🔹 Obtener cursos disponibles para el estudiante actual
    public static function get_cursos_disponibles()
    {
        global $db;
        session_start();

        $collection = $db->Curso;

        // Cursos "En Progreso" del usuario actual
        $cursosActuales = $collection->find(['id_usuario' => (int)$_SESSION['usuario']]);
        $cursosUsuario = [];
        foreach ($cursosActuales as $c) {
            $cursosUsuario[] = $c['descripcion'];
        }

        // Cursos "Disponibles" del mismo grado que no tenga ya
        $cursor = $collection->find([
            'estado' => 'Disponible',
            'grado' => $_SESSION['grado'],
            'descripcion' => ['$nin' => $cursosUsuario]
        ]);

        $cursos = [];
        foreach ($cursor as $doc) {
            $cursos[] = [
                'id_curso' => (int)$doc['_id'],
                'descripcion' => $doc['descripcion'] ?? '',
                'detalle' => $doc['detalle'] ?? ''
            ];
        }

        return $cursos;
    }

    // 🔹 Total de cursos distintos (por descripción)
    public static function get_total_cursos()
    {
        global $db;

        $collection = $db->Curso;
        $cursor = $collection->find([], ['projection' => ['descripcion' => 1]]);

        $cursos = [];
        foreach ($cursor as $doc) {
            $cursos[] = $doc['descripcion'] ?? '';
        }

        return array_unique($cursos);
    }

    // 🔹 Obtener notas del estudiante actual
    public static function get_notas()
    {
        global $db;
        session_start();

        $collectionNotas = $db->Nota;
        $collectionCursos = $db->Curso;

        $cursor = $collectionNotas->find(['id_usuario' => (int)$_SESSION['usuario']]);
        $cursos = [];

        foreach ($cursor as $nota) {
            $curso = $collectionCursos->findOne(['_id' => (int)$nota['id_curso']]);

            $cursos[] = [
                'id_curso' => (int)$nota['id_curso'],
                'nota' => $nota['nota'] ?? '',
                'fecha_inicio_trimestre' => $nota['fecha_inicio_trimestre'] ?? '',
                'fecha_final_trimestre' => $nota['fecha_final_trimestre'] ?? '',
                'estado' => $curso['estado'] ?? '',
                'descripcion' => $curso['descripcion'] ?? ''
            ];
        }

        return $cursos;
    }

    // 🔹 Guardar matrícula de un curso
    public static function guardarMatricula($cursoId)
    {
        global $db;
        session_start();

        $collectionCursos = $db->Curso;
        $collectionNotas = $db->Nota;

        // Buscar el curso base
        $curso = $collectionCursos->findOne(['_id' => (int)$cursoId]);
        if (!$curso) return false;

        // Crear un nuevo curso para el usuario (simula "duplicar" curso disponible)
        $nextId = self::getNextId($collectionCursos);

        $collectionCursos->insertOne([
            '_id' => $nextId,
            'descripcion' => $curso['descripcion'],
            'grado' => $curso['grado'],
            'detalle' => $curso['detalle'],
            'ruta_imagen' => $curso['ruta_imagen'] ?? '',
            'estado' => 'En Progreso',
            'id_usuario' => (int)$_SESSION['usuario']
        ]);

        // Insertar una nueva nota
        $collectionNotas->insertOne([
            '_id' => self::getNextId($collectionNotas),
            'id_curso' => $nextId,
            'fecha_inicio_trimestre' => date("Y-m-d"),
            'id_usuario' => (int)$_SESSION['usuario']
        ]);

        return true;
    }

    // 🔹 Obtener reportes (anual, trimestral, mensual)
    public static function get_reportes($reporte_anual, $reporte_trimestral, $reporte_mensual)
{
    global $db;
    session_start();

    $collectionNotas = $db->Nota;
    $collectionCursos = $db->Curso;

    $cursor = $collectionNotas->find(['id_usuario' => (int)$_SESSION['usuario']]);
    $cursos = [];

    $anioActual = (int)date('Y');
    $mesActual = (int)date('n');
    $trimestreActual = ceil($mesActual / 3);

    foreach ($cursor as $nota) {
        $curso = $collectionCursos->findOne(['_id' => (int)$nota['id_curso']]);
        if (!$curso) continue;

        try {
            $fechaInicio = isset($nota['fecha_inicio']) ? new DateTime($nota['fecha_inicio']) : null;
        } catch (Exception $e) {
            continue; // Si la fecha no es válida, saltar este registro
        }

        if ($fechaInicio === null) continue;

        $anioNota = (int)$fechaInicio->format('Y');
        $mesNota = (int)$fechaInicio->format('n');
        $trimestreNota = ceil($mesNota / 3);

        if (!empty($reporte_anual)) {
            if ($anioNota !== $anioActual) continue;
        } elseif (!empty($reporte_trimestral)) {
            if ($trimestreNota !== $trimestreActual || $anioNota !== $anioActual) continue;
        } elseif (!empty($reporte_mensual)) {
            if ($mesNota !== $mesActual || $anioNota !== $anioActual) continue;
        }

        $cursos[] = [
            'id_curso' => (int)$nota['id_curso'],
            'nota' => $nota['nota'] ?? '',
            'fecha_inicio_trimestre' => $nota['fecha_inicio'] ?? '',
            'fecha_final_trimestre' => $nota['fecha_final'] ?? '',
            'estado' => $curso['estado'] ?? '',
            'descripcion' => $curso['descripcion'] ?? ''
        ];
    }

    return $cursos;
}

    // 🔹 Generar ID consecutivo sin Counters
    private static function getNextId($collection)
    {
        $last = $collection->findOne([], ['sort' => ['_id' => -1], 'projection' => ['_id' => 1]]);
        return $last ? (int)$last['_id'] + 1 : 1;
    }
}
?>
