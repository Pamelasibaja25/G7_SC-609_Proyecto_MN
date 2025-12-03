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

        $val = strtolower(trim((string)$asistio));

        if (is_numeric($val)) {
            return ((int)$val) === 1;
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
        $nextId = $last ? ((int)$last['_id'] + 1) : 1;

        $asistioBool = self::parseAsistio($asistio);

        $collection->insertOne([
            '_id'        => $nextId,
            'id_usuario' => (int)$id_usuario,
            'id_curso'   => (int)$id_curso,
            'semana'     => $semana,
            'asistio'    => $asistioBool
        ]);

        return true;
    }

    public static function editar($id, $id_usuario, $id_curso, $semana, $asistio)
    {
        global $db;

        $asistioBool = self::parseAsistio($asistio);

        $db->Asistencia->updateOne(
            ['_id' => (int)$id],
            [
                '$set' => [
                    'id_usuario' => (int)$id_usuario,
                    'id_curso'   => (int)$id_curso,
                    'semana'     => $semana,
                    'asistio'    => $asistioBool
                ]
            ]
        );
    }

    public static function eliminar($id)
    {
        global $db;
        $db->Asistencia->deleteOne(['_id' => (int)$id]);
    }

    public static function lista_asistencias()
    {
        global $db;

        $cursor = $db->Asistencia->find([], ['sort' => ['_id' => 1]]);
        $resultado = [];

        foreach ($cursor as $doc) {
            $resultado[] = [
                '_id'        => (int)$doc['_id'],
                'id_usuario' => isset($doc['id_usuario']) ? (int)$doc['id_usuario'] : 0,
                'id_curso'   => isset($doc['id_curso']) ? (int)$doc['id_curso'] : 0,
                'semana'     => isset($doc['semana']) ? $doc['semana'] : '',
                'asistio'    => isset($doc['asistio']) ? (bool)$doc['asistio'] : false
            ];
        }

        return $resultado;
    }

    public static function lista_por_curso_y_semana($id_curso, $semana = null)
    {
        global $db;

        $filtro = ['id_curso' => (int)$id_curso];

        if ($semana !== null && $semana !== '') {
            $filtro['semana'] = $semana;
        }

        $cursor = $db->Asistencia->find($filtro, ['sort' => ['_id' => 1]]);
        $resultado = [];

        foreach ($cursor as $doc) {
            $resultado[] = [
                '_id'        => (int)$doc['_id'],
                'id_usuario' => isset($doc['id_usuario']) ? (int)$doc['id_usuario'] : 0,
                'id_curso'   => isset($doc['id_curso']) ? (int)$doc['id_curso'] : 0,
                'semana'     => isset($doc['semana']) ? $doc['semana'] : '',
                'asistio'    => isset($doc['asistio']) ? (bool)$doc['asistio'] : false
            ];
        }

        return $resultado;
    }

    public static function obtener_por_id($id)
    {
        global $db;

        $doc = $db->Asistencia->findOne(['_id' => (int)$id]);

        if (!$doc) {
            return null;
        }

        return [
            '_id'        => (int)$doc['_id'],
            'id_usuario' => isset($doc['id_usuario']) ? (int)$doc['id_usuario'] : 0,
            'id_curso'   => isset($doc['id_curso']) ? (int)$doc['id_curso'] : 0,
            'semana'     => isset($doc['semana']) ? $doc['semana'] : '',
            'asistio'    => isset($doc['asistio']) ? (bool)$doc['asistio'] : false
        ];
    }
}
