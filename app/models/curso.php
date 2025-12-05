<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_NoSQL/G7_SC-609_Proyecto_MN/config/database.php';

class Curso
{

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

            public static function get_actividades_por_curso($id_curso)
    {
        global $db;

        $collection = $db->Actividad;
        $cursor = $collection->find(['id_curso' => (int)$id_curso]);

        $actividades = [];
        foreach ($cursor as $doc) {
            $actividades[] = [
                'titulo' => $doc['titulo'] ?? '',
                'tipo' => $doc['tipo'] ?? '',
                'fecha_entrega' => $doc['fecha_entrega'] ?? ''
            ];
        }

        return $actividades;
    }

            public static function imprimir_actividades($id_curso)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="Actividades_Curso' . $id_curso . '.csv"');

        $actividades = self::get_actividades_por_curso($id_curso);
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Tipo', 'Titulo', 'Fecha de Entrega']);

        foreach ($actividades as $actividad) {
            fputcsv($output, [$actividad['tipo'], $actividad['titulo'],$actividad['fecha_entrega']]);
        }

        fclose($output);
        exit;
    }

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

        //Conversión correcta de la fecha
        if (isset($nota['fecha_inicio']) && $nota['fecha_inicio'] instanceof MongoDB\BSON\UTCDateTime) {
            $fechaInicio = $nota['fecha_inicio']->toDateTime()->format('Y-m-d');
        } else {
            $fechaInicio = $nota['fecha_inicio'] ?? '';
        }

        if (isset($nota['fecha_final']) && $nota['fecha_final'] instanceof MongoDB\BSON\UTCDateTime) {
            $fechaFinal = $nota['fecha_final']->toDateTime()->format('Y-m-d');
        } else {
            $fechaFinal = $nota['fecha_final'] ?? '';
        }

        $cursos[] = [
            'id_curso' => (int)$nota['id_curso'],
            'nota' => $nota['nota'] ?? '',
            'fecha_inicio_trimestre' => $fechaInicio,
            'fecha_final_trimestre' => $fechaFinal,
            'estado' => $curso['estado'] ?? '',
            'descripcion' => $curso['descripcion'] ?? ''
        ];
    }

    return $cursos;
}



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
            if (isset($nota['fecha_inicio']) && $nota['fecha_inicio'] instanceof MongoDB\BSON\UTCDateTime) {
                $fechaInicio = $nota['fecha_inicio']->toDateTime();
            } elseif (!empty($nota['fecha_inicio'])) {
                $fechaInicio = new DateTime($nota['fecha_inicio']);
            } else {
                continue;
            }
        } catch (Exception $e) {
            continue; 
        }

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
            'fecha_inicio_trimestre' => $fechaInicio->format('Y-m-d'),
            'fecha_final_trimestre' => isset($nota['fecha_final']) && $nota['fecha_final'] instanceof MongoDB\BSON\UTCDateTime
                ? $nota['fecha_final']->toDateTime()->format('Y-m-d')
                : ($nota['fecha_final'] ?? ''),
            'estado' => $curso['estado'] ?? '',
            'descripcion' => $curso['descripcion'] ?? ''
        ];
    }

    return $cursos;
}



    private static function getNextId($collection)
    {
        $last = $collection->findOne([], ['sort' => ['_id' => -1], 'projection' => ['_id' => 1]]);
        return $last ? (int)$last['_id'] + 1 : 1;
    }
}
?>
