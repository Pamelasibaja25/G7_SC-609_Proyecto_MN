<?php
// app/models/grupo.php

require_once __DIR__ . '/../../config/database.php';

class Grupo
{
    public static function registrar($id_curso, $grupo, $capacidad)
    {
        global $db;

        $collection = $db->Grupo;

        // Generar ID consecutivo
        $last = $collection->findOne([], ['sort' => ['_id' => -1]]);
        $nextId = $last ? ((int)$last['_id'] + 1) : 1;

        $collection->insertOne([
            '_id'      => $nextId,
            'id_curso' => (int)$id_curso,
            'grupo'    => $grupo,
            'capacidad'=> (int)$capacidad
        ]);

        return true;
    }

    public static function editar($id, $id_curso, $grupo, $capacidad)
    {
        global $db;

        $db->Grupo->updateOne(
            ['_id' => (int)$id],
            [
                '$set' => [
                    'id_curso'  => (int)$id_curso,
                    'grupo'     => $grupo,
                    'capacidad' => (int)$capacidad
                ]
            ]
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

        $cursor = $db->Grupo->find([], ['sort' => ['_id' => 1]]);
        $resultado = [];

        foreach ($cursor as $g) {
            $resultado[] = [
                '_id'      => (int)$g['_id'],
                'id_curso' => isset($g['id_curso']) ? (int)$g['id_curso'] : 0,
                'grupo'    => $g['grupo'] ?? '',
                'capacidad'=> isset($g['capacidad']) ? (int)$g['capacidad'] : 0
            ];
        }

        return $resultado;
    }

    public static function lista_por_curso($id_curso)
    {
        global $db;

        $cursor = $db->Grupo->find(
            ['id_curso' => (int)$id_curso],
            ['sort' => ['_id' => 1]]
        );

        $resultado = [];

        foreach ($cursor as $g) {
            $resultado[] = [
                '_id'      => (int)$g['_id'],
                'id_curso' => isset($g['id_curso']) ? (int)$g['id_curso'] : 0,
                'grupo'    => $g['grupo'] ?? '',
                'capacidad'=> isset($g['capacidad']) ? (int)$g['capacidad'] : 0
            ];
        }

        return $resultado;
    }

    public static function obtener_por_id($id)
    {
        global $db;

        $doc = $db->Grupo->findOne(['_id' => (int)$id]);

        if (!$doc) {
            return null;
        }

        return [
            '_id'      => (int)$doc['_id'],
            'id_curso' => isset($doc['id_curso']) ? (int)$doc['id_curso'] : 0,
            'grupo'    => $doc['grupo'] ?? '',
            'capacidad'=> isset($doc['capacidad']) ? (int)$doc['capacidad'] : 0
        ];
    }
}