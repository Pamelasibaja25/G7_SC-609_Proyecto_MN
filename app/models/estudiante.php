<?php
// Ruta correcta a la conexión de MongoDB
require_once __DIR__ . '/../../config/database.php';

class Estudiante
{
    public static function registrar($nombre, $cedula, $fecha_nacimiento, $grado, $escuela)
    {
        global $db;

        // Si en Mongo la colección se llama "Estudiante"
        $collection = $db->Estudiante;

        // Generar ID consecutivo como en Profesor
        $last = $collection->findOne([], ['sort' => ['_id' => -1]]);
        $nextId = $last ? ((int) $last['_id'] + 1) : 1;

        $collection->insertOne([
            '_id' => $nextId,
            'nombre' => $nombre,
            'cedula' => $cedula,
            'fecha_nacimiento' => $fecha_nacimiento,
            'grado' => $grado,
            'escuela' => $escuela
        ]);

        return true;
    }


    /**
     * Editar datos de un estudiante
     */
    public static function editar($id, $cedula, $fecha_nacimiento, $grado, $escuela)
    {
        global $db;

        $collection = $db->Estudiante;

        // Verificar que exista
        $estudiante = $collection->findOne(['_id' => (int) $id]);
        if (!$estudiante) {
            throw new Exception("El estudiante con ID $id no existe.");
        }

        $collection->updateOne(
            ['_id' => (int) $id],
            [
                '$set' => [
                    'cedula' => $cedula,
                    'fecha_nacimiento' => $fecha_nacimiento,
                    'grado' => $grado,
                    'escuela' => $escuela
                ]
            ]
        );

        return true;
    }

    /**
     * Eliminar estudiante
     */
    public static function eliminar($id)
    {
        global $db;

        $collection = $db->Estudiante;
        $collection->deleteOne(['_id' => (int) $id]);
    }

    /**
     * Obtener un estudiante por ID (útil si lo necesitas en algún editar.php)
     */
    public static function obtener_por_id($id)
    {
        global $db;

        $collection = $db->Estudiante;
        $estudiante = $collection->findOne(['_id' => (int) $id]);

        if (!$estudiante) {
            throw new Exception("El estudiante con ID $id no existe.");
        }


        if (!$estudiante) {
            return null;
        }

        // Normalizamos a array simple
        return [
            '_id' => (int) $estudiante['_id'],
            'nombre' => $estudiante['nombre'] ?? '',
            'cedula' => $estudiante['cedula'] ?? '',
            'fecha_nacimiento' => $estudiante['fecha_nacimiento'] ?? '',
            'grado' => $estudiante['grado'] ?? '',
            'escuela' => $estudiante['escuela'] ?? '',
        ];
    }

    /**
     * Lista general de estudiantes (para admin)
     */
    public static function lista_estudiantes()
    {
        global $db;

        $cursor = $db->Estudiante->find();
        $collectionEscuelas = $db->Escuela;
        $collectionUsuarios = $db->Usuario;

        $resultado = [];

        foreach ($cursor as $p) {
            if (isset($p['id_escuela']) and isset($p['id_usuario'])) {
                $escuelaDoc = $collectionEscuelas->findOne(['_id' => (int) $p['id_escuela']]);
                $usuario = $collectionUsuarios->findOne(['_id' => (int) $p['id_usuario']]);
                $resultado[] = [
                    '_id' => (int) $p['_id'],
                    'nombre' => $usuario['nombre'] ?? $p['nombre'],
                    'cedula' => $p['cedula'],
                    'fecha_nacimiento' => $p['fecha_nacimiento'],
                    'grado' => $p['grado'],
                    'escuela' => $escuelaDoc['nombre'] ?? $p['escuela'],
                ];
            } else {
                $resultado[] = [
                    '_id' => (int) $p['_id'],
                    'nombre' => $p['nombre'],
                    'cedula' => $p['cedula'],
                    'fecha_nacimiento' => $p['fecha_nacimiento'],
                    'grado' => $p['grado'],
                    'escuela' => $p['escuela'],
                ];
            }

        }

        return $resultado;
    }
    public static function get_estudiantes()
    {
        global $db;
        session_start();

        $collectionEstudiantes = $db->Estudiante;
        $collectionUsuarios = $db->Usuario;

        // Traer todos los estudiantes
        $estudiantes = $collectionEstudiantes->find();

        $resultado = [];
        $nombresUnicos = [];

        foreach ($estudiantes as $est) {
            $usuario = $collectionUsuarios->findOne(['_id' => (int) $est['id_usuario']]);
            $nombre = $usuario['nombre'] ?? 'Sin nombre';

            // Verificar si ya se agregó un estudiante con ese nombre
            if (!in_array($nombre, $nombresUnicos)) {
                $nombresUnicos[] = $nombre;

                $resultado[] = [
                    'id_estudiante' => (int) $est['id_usuario'],
                    'nombre' => $nombre
                ];
            }
        }

        return $resultado;
    }
    public static function lista_estudiantes_admin()
    {
        return self::lista_estudiantes();
    }

    public static function get_reportes($id_estudiante, $grado, $id_curso)
    {
        global $db;
        session_start();

        $collectionNotas = $db->Nota;
        $collectionCursos = $db->Curso;
        $collectionEstudiantes = $db->Estudiante;
        $collectionUsuarios = $db->Usuario;

        $filtros = [];

        if ($id_estudiante != "All") {
            $filtros['id_usuario'] = (int) $id_estudiante;
        }

        $notas = $collectionNotas->find($filtros);
        $cursos = [];

        foreach ($notas as $nota) {
            $curso = $collectionCursos->findOne(['_id' => (int) $nota['id_curso']]);
            $estudiante = $collectionEstudiantes->findOne(['id_usuario' => (int) $nota['id_usuario']]);
            $usuario = $collectionUsuarios->findOne(['_id' => (int) $nota['id_usuario']]);

            // Aplicar filtros adicionales
            if ($grado != "All" && isset($curso['grado']) && $curso['grado'] != $grado)
                continue;
            if ($id_curso != "All" && isset($curso['descripcion']) && $curso['descripcion'] != $id_curso)
                continue;

            // Conversión de fechas MongoDB -> string
            $fechaInicio = isset($nota['fecha_inicio']) && $nota['fecha_inicio'] instanceof MongoDB\BSON\UTCDateTime
                ? $nota['fecha_inicio']->toDateTime()->format('Y-m-d')
                : ($nota['fecha_inicio'] ?? '');

            $fechaFinal = isset($nota['fecha_final']) && $nota['fecha_final'] instanceof MongoDB\BSON\UTCDateTime
                ? $nota['fecha_final']->toDateTime()->format('Y-m-d')
                : ($nota['fecha_final'] ?? '');

            $cursos[] = [
                'fecha_inicio_trimestre' => $fechaInicio,
                'fecha_final_trimestre' => $fechaFinal,
                'grado' => $curso['grado'] ?? '',
                'descripcion' => $curso['descripcion'] ?? '',
                'estado' => $curso['estado'] ?? '',
                'nombre' => $usuario['nombre'] ?? 'Sin nombre',
                'nota' => $nota['nota'] ?? ''
            ];
        }

        return $cursos;
    }

    public static function imprimir_reporte()
    {
        session_start();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="Reporte_Rendimiento.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Fecha Inicio', 'Fecha Final', 'Grado', 'Curso', 'Estado', 'Estudiante', 'Nota']);

        foreach ($_SESSION['reportes-rendimiento'] as $reporte) {
            fputcsv($output, [
                $reporte["fecha_inicio_trimestre"],
                $reporte["fecha_final_trimestre"],
                $reporte["grado"],
                $reporte["descripcion"],
                $reporte["estado"],
                $reporte["nombre"],
                $reporte["nota"]
            ]);
        }

        fclose($output);
        exit;
    }

    public static function modificar_info($escuela)
    {
        global $db;
        session_start();

        $collectionEstudiantes = $db->Estudiante;
        $collectionEscuelas = $db->Escuela;

        // Actualizar el campo id_escuela del estudiante actual
        $collectionEstudiantes->updateOne(
            ['id_usuario' => (int) $_SESSION['usuario']],
            ['$set' => ['id_escuela' => (int) $escuela]]
        );

        // Obtener los datos de la escuela seleccionada
        $escuelaDoc = $collectionEscuelas->findOne(['_id' => (int) $escuela]);
        if ($escuelaDoc) {
            $_SESSION['id_escuela'] = (int) $escuelaDoc['_id'];
            $_SESSION['escuela'] = $escuelaDoc['nombre'] ?? $escuelaDoc['descripcion'] ?? 'Sin nombre';
        }

        return true;
    }
}