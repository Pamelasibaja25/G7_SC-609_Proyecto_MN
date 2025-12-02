<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/config/database.php';

class Calendario
{
    public static function registrar($id_curso, $semana, $fecha_inicio, $fecha_fin)
    {
        global $db;

        $collection = $db->Calendario;

        $last = $collection->findOne([], ['sort' => ['_id' => -1]]);
        $nextId = $last ? ((int)$last['_id'] + 1) : 1;

        $collection->insertOne([
            '_id' => $nextId,
            'id_curso' => (int)$id_curso,
            'semana' => $semana,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin
        ]);

        return true;
    }

    public static function editar($id, $id_curso, $semana, $fecha_inicio, $fecha_fin)
    {
        global $db;

        $db->Calendario->updateOne(
            ['_id' => (int)$id],
            ['$set' => [
                'id_curso' => (int)$id_curso,
                'semana' => $semana,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin
            ]]
        );
    }

    public static function eliminar($id)
    {
        global $db;

        $db->Calendario->deleteOne(['_id' => (int)$id]);
    }

    public static function lista_calendario()
    {
        global $db;

        $cursor = $db->Calendario->find([], ['sort' => ['fecha_inicio' => 1]]);
        $resultado = [];

        foreach ($cursor as $c) {
            $resultado[] = [
                '_id' => (int)$c['_id'],
                'id_curso' => (int)$c['id_curso'],
                'semana' => $c['semana'],
                'fecha_inicio' => $c['fecha_inicio'],
                'fecha_fin' => $c['fecha_fin']
            ];
        }

        return $resultado;
    }

    public static function lista_por_curso($id_curso)
    {
        global $db;

        $cursor = $db->Calendario->find(
            ['id_curso' => (int)$id_curso],
            ['sort' => ['fecha_inicio' => 1]]
        );

        $resultado = [];
        foreach ($cursor as $c) {
            $resultado[] = [
                '_id' => (int)$c['_id'],
                'id_curso' => (int)$c['id_curso'],
                'semana' => $c['semana'],
                'fecha_inicio' => $c['fecha_inicio'],
                'fecha_fin' => $c['fecha_fin']
            ];
        }

        return $resultado;
    }
}
