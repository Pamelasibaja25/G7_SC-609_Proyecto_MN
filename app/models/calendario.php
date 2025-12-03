<?php
// app/models/calendario.php

require_once __DIR__ . '/../../config/database.php';

class Calendario
{

    public static function lista_calendario($id_curso = null)
    {
        global $db;

        $filtro = [];
        if ($id_curso !== null && $id_curso !== '') {
            $filtro['id_curso'] = (int)$id_curso;
        }

        $cursor = $db->Calendario->find(
            $filtro,
            [
                'sort' => [
                    'id_curso'      => 1,
                    'fecha_inicio'  => 1
                ]
            ]
        );

        $resultado = [];

        foreach ($cursor as $doc) {
            $resultado[] = [
                '_id'          => (int)$doc['_id'],
                'id_curso'     => isset($doc['id_curso']) ? (int)$doc['id_curso'] : 0,
                'semana'       => $doc['semana']       ?? '',
                'fecha_inicio' => $doc['fecha_inicio'] ?? '',
                'fecha_fin'    => $doc['fecha_fin']    ?? '',
            ];
        }

        return $resultado;
    }


    public static function semana_actual($id_curso = null, $fecha = null)
    {
        global $db;

        if ($fecha === null) {
            // Formato igual al JSON: YYYY-MM-DD
            $fecha = date('Y-m-d');
        }

        $filtro = [];
        if ($id_curso !== null && $id_curso !== '') {
            $filtro['id_curso'] = (int)$id_curso;
        }

        $cursor = $db->Calendario->find($filtro);

        foreach ($cursor as $doc) {
            $inicio = $doc['fecha_inicio'] ?? null;
            $fin    = $doc['fecha_fin'] ?? null;

            if (!$inicio || !$fin) {
                continue;
            }

            if ($fecha >= $inicio && $fecha <= $fin) {
                return [
                    '_id'          => (int)$doc['_id'],
                    'id_curso'     => isset($doc['id_curso']) ? (int)$doc['id_curso'] : 0,
                    'semana'       => $doc['semana']       ?? '',
                    'fecha_inicio' => $inicio,
                    'fecha_fin'    => $fin,
                ];
            }
        }

        return null;
    }
}
