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
    $nextId = $last ? ((int)$last['_id'] + 1) : 1;

    $collection->insertOne([
        '_id'              => $nextId,
        'nombre'           => $nombre,
        'cedula'           => $cedula,
        'fecha_nacimiento' => $fecha_nacimiento,
        'grado'            => $grado,
        'escuela'          => $escuela
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
        $estudiante = $collection->findOne(['_id' => (int)$id]);
        if (!$estudiante) {
            throw new Exception("El estudiante con ID $id no existe.");
        }

        $collection->updateOne(
            ['_id' => (int)$id],
            [
                '$set' => [
                    'cedula'           => $cedula,
                    'fecha_nacimiento' => $fecha_nacimiento,
                    'grado'            => $grado,
                    'escuela'          => $escuela
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
        $collection->deleteOne(['_id' => (int)$id]);
    }

    /**
     * Obtener un estudiante por ID (útil si lo necesitas en algún editar.php)
     */
    public static function obtener_por_id($id)
    {
        global $db;

        $collection = $db->Estudiante;
  $estudiante = $collection->findOne(['_id' => (int)$id]);

if (!$estudiante) {
    throw new Exception("El estudiante con ID $id no existe.");
}


        if (!$estudiante) {
            return null;
        }

        // Normalizamos a array simple
        return [
            '_id'              => (int)$estudiante['_id'],
            'nombre'           => $estudiante['nombre'] ?? '',
            'cedula'           => $estudiante['cedula'] ?? '',
            'fecha_nacimiento' => $estudiante['fecha_nacimiento'] ?? '',
            'grado'            => $estudiante['grado'] ?? '',
            'escuela'          => $estudiante['escuela'] ?? '',
        ];
    }

    /**
     * Lista general de estudiantes (para admin)
     */
    public static function lista_estudiantes()
    {
        global $db;

        $collection = $db->Estudiante;
        $cursor = $collection->find();

        $resultado = [];

        foreach ($cursor as $e) {
            // Aquí evitamos el warning de "Trying to access array offset on value of type null"
            $resultado[] = [
                '_id'              => (int)($e['_id'] ?? 0),
                'nombre'           => $e['nombre'] ?? '',
                'cedula'           => $e['cedula'] ?? '',
                'fecha_nacimiento' => $e['fecha_nacimiento'] ?? '',
                'grado'            => $e['grado'] ?? '',
                'escuela'          => $e['escuela'] ?? '',
            ];
        }

        return $resultado;
    }

    /**
     * Alias por si tu controller llama get_estudiantes_admin()
     * y por dentro usa otro nombre.
     */
    public static function lista_estudiantes_admin()
    {
        return self::lista_estudiantes();
    }
}