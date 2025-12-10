<?php

require_once __DIR__ . '/../../config/database.php';

class Asistencia
{
    private static function parseAsistio($asistio)
    {
        //  true = presente, false = ausente
        if (is_bool($asistio)) {
            return $asistio;
        }

        $val = strtolower(trim((string) $asistio));

        if (is_numeric($val)) {
            return ((int) $val) === 1;
        }


        $presentes = ['1', 'true', 'sí', 'si', 'presente', 'present'];
        return in_array($val, $presentes, true);
    }

    public static function registrar($id_usuario, $id_curso, $semana, $asistio)
    {
        global $db;

        $collection = $db->Asistencia;

        // Generar ID consecutivo
        $last = $collection->findOne([], ['sort' => ['_id' => -1]]);
        $nextId = $last ? ((int) $last['_id'] + 1) : 1;

        $asistioBool = self::parseAsistio($asistio);
        $collection_semana = $db->Calendario;

        $last_calendario = $collection->findOne([], ['sort' => ['_id' => -1]]);
        $nextId_Calendario = $last_calendario ? ($last_calendario['_id'] + 1) : 1;

        $hoy = new DateTime();

        $inicioSemana = clone $hoy;
        $finSemana = clone $hoy;

        // Ajustar al inicio de la semana (lunes)
        $inicioSemana->modify('monday this week');

        // Ajustar al final de la semana (domingo)
        $finSemana->modify('sunday this week');

        $collection_semana->insertOne([
            '_id' => $nextId_Calendario,
            'id_curso' => (int) $id_curso,
            'semana' => $semana,
            'fecha_inicio' => $inicioSemana->format('Y-m-d'),
            'fecha_fin' => $finSemana->format('Y-m-d'),
        ]);

        $collection->insertOne([
            '_id' => $nextId,
            'id_usuario' => (int) $id_usuario,
            'id_curso' => (int) $id_curso,
            'id_semana' => $nextId_Calendario,
            'asistio' => $asistioBool
        ]);

        return true;
    }

    public static function editar($id, $id_usuario, $id_curso, $semana, $asistio)
    {
        global $db;

        $asistioBool = self::parseAsistio($asistio);

        $db->Asistencia->updateOne(
            ['_id' => (int) $id],
            [
                '$set' => [
                    'id_usuario' => (int) $id_usuario,
                    'id_curso' => (int) $id_curso,
                    'semana' => $semana,
                    'asistio' => $asistioBool
                ]
            ]
        );
    }

    public static function eliminar($id)
    {
        global $db;
        $db->Asistencia->deleteOne(['_id' => (int) $id]);
    }

    public static function lista_asistencias()
    {
        global $db;

        $cursor = $db->Asistencia->find([], ['sort' => ['_id' => 1]]);
        $resultado = [];
        $collectionCalendario = $db->Calendario;

        foreach ($cursor as $doc) {
            $calendario = $collectionCalendario->findOne(['_id' => (int) $doc['id_semana']]);

            $resultado[] = [
                '_id' => (int) $doc['_id'],
                'id_usuario' => isset($doc['id_usuario']) ? (int) $doc['id_usuario'] : 0,
                'id_curso' => isset($doc['id_curso']) ? (int) $doc['id_curso'] : 0,
                'semana' => $calendario['semana'],
                'asistio' => isset($doc['asistio']) ? (bool) $doc['asistio'] : false
            ];
        }

        return $resultado;
    }

    public static function lista_por_curso_y_semana($id_curso, $semana = null)
    {
        global $db;

        $filtro = ['id_curso' => (int) $id_curso];

        if ($semana !== null && $semana !== '') {
            $filtro['semana'] = $semana;
        }

        $cursor = $db->Asistencia->find($filtro, ['sort' => ['_id' => 1]]);
        $resultado = [];

        foreach ($cursor as $doc) {
            $resultado[] = [
                '_id' => (int) $doc['_id'],
                'id_usuario' => isset($doc['id_usuario']) ? (int) $doc['id_usuario'] : 0,
                'id_curso' => isset($doc['id_curso']) ? (int) $doc['id_curso'] : 0,
                'semana' => isset($doc['semana']) ? $doc['semana'] : '',
                'asistio' => isset($doc['asistio']) ? (bool) $doc['asistio'] : false
            ];
        }

        return $resultado;
    }

    public static function obtener_por_id($id)
    {
        global $db;

        $doc = $db->Asistencia->findOne(['_id' => (int) $id]);

        if (!$doc) {
            return null;
        }

        return [
            '_id' => (int) $doc['_id'],
            'id_usuario' => isset($doc['id_usuario']) ? (int) $doc['id_usuario'] : 0,
            'id_curso' => isset($doc['id_curso']) ? (int) $doc['id_curso'] : 0,
            'semana' => isset($doc['semana']) ? $doc['semana'] : '',
            'asistio' => isset($doc['asistio']) ? (bool) $doc['asistio'] : false
        ];
    }

    public static function imprimir_reporte()
    {
        session_start();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="Reporte_Assitencia.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Fecha Inicio', 'Fecha Final', 'Curso', 'Estudiante', 'Semana', 'Asistencia']);

        foreach ($_SESSION['reporte_asistencia'] as $reporte) {
            fputcsv($output, [
                $reporte["fecha_inicio_trimestre"],
                $reporte["fecha_final_trimestre"],
                $reporte["descripcion"],
                $reporte["nombre"],
                $reporte["semana"],
                $reporte["asistencia"]
            ]);
        }

        fclose($output);
        exit;
    }

    public static function get_reportes($id_estudiante, $id_curso)
    {
        global $db;
        session_start();

        $collectionCursos = $db->Curso;
        $collectionUsuarios = $db->Usuario;
        $collectionAsistencia = $db->Asistencia;
        $collectionCalendario = $db->Calendario;

        $filtros = [];

        if ($id_estudiante != "All") {
            $filtros['id_usuario'] = (int) $id_estudiante;
        }

        $asistencia = $collectionAsistencia->find($filtros);
        $cursos = [];

        foreach ($asistencia as $line) {
            $curso = $collectionCursos->findOne(['_id' => (int) $line['id_curso']]);
            $usuario = $collectionUsuarios->findOne(['_id' => (int) $line['id_usuario']]);
            $calendario = $collectionCalendario->findOne(['_id' => (int) $line['id_semana']]);


            if ($id_curso != "All" && isset($curso['descripcion']) && $curso['descripcion'] != $id_curso)
                continue;

            // Conversión de fechas MongoDB -> string
            $fechaInicio = isset($calendario['fecha_inicio']) && $calendario['fecha_inicio'] instanceof MongoDB\BSON\UTCDateTime
                ? $calendario['fecha_inicio']->toDateTime()->format('Y-m-d')
                : ($calendario['fecha_inicio'] ?? '');

            $fechaFinal = isset($calendario['fecha_fin']) && $calendario['fecha_fin'] instanceof MongoDB\BSON\UTCDateTime
                ? $calendario['fecha_fin']->toDateTime()->format('Y-m-d')
                : ($calendario['fecha_fin'] ?? '');

            $cursos[] = [
                'fecha_inicio_trimestre' => $fechaInicio,
                'fecha_final_trimestre' => $fechaFinal,
                'descripcion' => $curso['descripcion'] ?? '',
                'nombre' => $usuario['nombre'] ?? 'Sin nombre',
                'semana' => $calendario['semana'] ?? '',
                'asistencia' => $line['asistio'] ?? false
            ];
        }

        return $cursos;
    }
}
