<?php
// app/models/metricas.php

require_once __DIR__ . '/../../config/database.php';

class Metricas
{
    private static function safeCount($collectionName, $filter = [])
    {
        global $db;

        try {
            if (!isset($db->$collectionName)) {
                return 0;
            }
            return $db->$collectionName->countDocuments($filter);
        } catch (\Throwable $e) {
            return 0;
        }
    }

    private static function safeAggregate($collectionName, array $pipeline)
    {
        global $db;

        try {
            if (!isset($db->$collectionName)) {
                return [];
            }

            $cursor = $db->$collectionName->aggregate($pipeline);
            $result = [];

            foreach ($cursor as $doc) {
                $result[] = $doc;
            }

            return $result;
        } catch (\Throwable $e) {
            return [];
        }
    }


    public static function get_total_usuarios()
    {
        // Ajusta 'Usuario' si tu colección se llama diferente (ej: 'Usuarios', 'Users').
        return self::safeCount('Usuario');
    }

    public static function get_total_estudiantes()
    {
        return self::safeCount('Estudiante');
    }

    public static function get_total_cursos()
    {
        return self::safeCount('Curso');
    }

    public static function get_total_escuelas()
    {
        return self::safeCount('Escuela');
    }

    public static function get_total_profesores()
    {
        return self::safeCount('Profesor');
    }


    public static function get_cursos_matriculados_anio($anio = null)
    {
        if ($anio === null) {
            $anio = (int)date('Y');
        }

        global $db;

        try {
            if (!isset($db->Matricula)) {
                return 0;
            }

            $pipeline = [
                [
                    '$match' => [
                        '$expr' => [
                            '$eq' => [
                                ['$year' => '$fecha_matricula'],
                                $anio
                            ]
                        ]
                    ]
                ],
                [
                    '$count' => 'total'
                ]
            ];

            $cursor = $db->Matricula->aggregate($pipeline);
            $docs = iterator_to_array($cursor, false);

            if (empty($docs)) {
                return 0;
            }

            return isset($docs[0]['total']) ? (int)$docs[0]['total'] : 0;

        } catch (\Throwable $e) {
            return 0;
        }
    }

 
    public static function get_cursos_por_estado()
    {
        $pipeline = [
            [
                '$group' => [
                    '_id'   => '$estado',
                    'total' => ['$sum' => 1]
                ]
            ],
            [
                '$sort' => ['_id' => 1]
            ]
        ];

        $raw = self::safeAggregate('Curso', $pipeline);

        $resultado = [];

        foreach ($raw as $doc) {
            $estado = isset($doc['_id']) ? (string)$doc['_id'] : 'Sin estado';
            $total  = isset($doc['total']) ? (int)$doc['total'] : 0;
            $resultado[$estado] = $total;
        }

        return $resultado;
    }
}
