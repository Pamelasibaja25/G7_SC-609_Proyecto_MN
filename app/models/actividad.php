<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/config/database.php';

class Actividad
{
    public static function registrar($id_curso, $tipo, $titulo, $fecha_entrega)
    {
        global $db;

        $collection = $db->Actividad;

        // Generar ID consecutivo similar a Profesor
        $last = $collection->findOne([], ['sort' => ['_id' => -1]]);
        $nextId = $last ? ((int)$last['_id'] + 1) : 1;

        $collection->insertOne([
            '_id' => $nextId,
            'id_curso' => (int)$id_curso,
            'tipo' => $tipo,
            'titulo' => $titulo,
            'fecha_entrega' => $fecha_entrega
        ]);

        return true;
    }

    public static function editar($id, $id_curso, $tipo, $titulo, $fecha_entrega)
    {
        global $db;

        $db->Actividad->updateOne(
            ['_id' => (int)$id],
            ['$set' => [
                'id_curso' => (int)$id_curso,
                'tipo' => $tipo,
                'titulo' => $titulo,
                'fecha_entrega' => $fecha_entrega
            ]]
        );
    }

    public static function eliminar($id)
    {
        global $db;

        $db->Actividad->deleteOne(['_id' => (int)$id]);
    }

    public static function lista_actividades()
    {
        global $db;

        $cursor = $db->Actividad->find([], ['sort' => ['fecha_entrega' => 1]]);
        $resultado = [];

        foreach ($cursor as $a) {
            $resultado[] = [
                '_id' => (int)$a['_id'],
                'id_curso' => (int)$a['id_curso'],
                'tipo' => $a['tipo'],
                'titulo' => $a['titulo'],
                'fecha_entrega' => $a['fecha_entrega']
            ];
        }

        return $resultado;
    }

    public static function actividades_por_curso($id_curso)
    {
        global $db;

        $cursor = $db->Actividad->find(
            ['id_curso' => (int)$id_curso],
            ['sort' => ['fecha_entrega' => 1]]
        );

        $resultado = [];
        foreach ($cursor as $a) {
            $resultado[] = [
                '_id' => (int)$a['_id'],
                'id_curso' => (int)$a['id_curso'],
                'tipo' => $a['tipo'],
                'titulo' => $a['titulo'],
                'fecha_entrega' => $a['fecha_entrega']
            ];
        }

        return $resultado;
    }
}
