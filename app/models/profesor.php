<?php
require_once __DIR__ . '/../../config/database.php';

class Profesor
{
    public static function registrar($nombre, $cedula, $telefono, $correo, $especialidad)
    {
        global $db;

        $collection = $db->Profesor;

        // Generar ID consecutivo
        $last = $collection->findOne([], ['sort' => ['_id' => -1]]);
        $nextId = $last ? ($last['_id'] + 1) : 1;

        $collection->insertOne([
            '_id' => $nextId,
            'nombre' => $nombre,
            'cedula' => $cedula,
            'telefono' => $telefono,
            'correo' => $correo,
            'especialidad' => $especialidad
        ]);

        return true;
    }

    public static function especialidades_cursos()
    {
        global $db;

        $collectionCursos = $db->Curso;
        $cursor = $collectionCursos->find([], ['projection' => ['descripcion' => 1]]);

        $lista = [];

        foreach ($cursor as $curso) {
            if (!empty($curso['descripcion'])) {
                $lista[] = $curso['descripcion'];
            }
        }

        return array_unique($lista);
    }

    public static function editar($id, $nombre, $cedula, $telefono, $correo, $especialidad)
    {
        global $db;

        $db->Profesor->updateOne(
            ['_id' => $id],
            ['$set' => [
                'nombre' => $nombre,
                'cedula' => $cedula,
                'telefono' => $telefono,
                'correo' => $correo,
                'especialidad' => $especialidad
            ]]
        );
    }

    public static function eliminar($id)
    {
        global $db;
        $db->Profesor->deleteOne(['_id' => $id]);
    }

    public static function resumen_profesores()
    {
        global $db;

        $cursor = $db->Profesor->aggregate([
            ['$group' => [
                '_id' => '$especialidad',
                'total' => ['$sum' => 1]
            ]]
        ]);

        $resultado = [];
        foreach ($cursor as $row) {
            $resultado[$row['_id']] = $row['total'];
        }

        return $resultado;
    }

    public static function lista_profesores()
    {
        global $db;

        $cursor = $db->Profesor->find();
        $resultado = [];

        foreach ($cursor as $p) {
            $resultado[] = [
                '_id' => (int)$p['_id'],
                'nombre' => $p['nombre'],
                'cedula' => $p['cedula'],
                'telefono' => $p['telefono'],
                'correo' => $p['correo'],
                'especialidad' => $p['especialidad']
            ];
        }

        return $resultado;
    }

}
?>
