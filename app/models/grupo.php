<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/config/database.php';

class Grupo
{
    public static function registrar($id_curso, $grupo, $capacidad)
    {
        global $db;

        $collection = $db->Grupo;

        $last = $collection->findOne([], ['sort' => ['_id' => -1]]);
        $nextId = $last ? ((int)$last['_id'] + 1) : 1;

        $collection->insertOne([
            '_id' => $nextId,
            'id_curso' => (int)$id_curso,
            'grupo' => $grupo,
            'capacidad' => (int)$capacidad
        ]);

        return true;
    }

    public static function editar($id, $id_curso, $grupo, $capacidad)
    {
        global $db;

        $db->Grupo->updateOne(
            ['_id' => (int)$id],
            ['$set' => [
                'id_curso' => (int)$id_curso,
                'grupo' => $grupo,
                'capacidad' => (int)$capacidad
            ]]
        );
    }

    public static function eliminar($id)
    {
        global $db;

        $db->Grupo->deleteOne(['_id' => (int)$id]);
    }

    public static function lista_grupos()
    {
        global $db;

        $cursor = $db->Grupo->find();
        $resultado = [];

        foreach ($cursor as $g) {
            $resultado[] = [
                '_id' => (int)$g['_id'],
                'id_curso' => (int)$g['id_curso'],
                'grupo' => $g['grupo'],
                'capacidad' => (int)$g['capacidad']
            ];
        }

        return $resultado;
    }

    public static function lista_por_curso($id_curso)
    {
        global $db;

        $cursor = $db->Grupo->find(['id_curso' => (int)$id_curso]);

        $resultado = [];
        foreach ($cursor as $g) {
            $resultado[] = [
                '_id' => (int)$g['_id'],
                'id_curso' => (int)$g['id_curso'],
                'grupo' => $g['grupo'],
                'capacidad' => (int)$g['capacidad']
            ];
        }

        return $resultado;
    }
}
