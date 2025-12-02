<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/config/database.php';

class Asistencia
{
    public static function registrar($id_usuario, $id_curso, $semana, $asistio)
    {
        global $db;

        $collection = $db->Asistencia;

        $last = $collection->findOne([], ['sort' => ['_id' => -1]]);
        $nextId = $last ? ((int)$last['_id'] + 1) : 1;

        // $asistio viene normalmente como '1' o '0' desde el formulario
        $asistioBool = filter_var($asistio, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if ($asistioBool === null) {
            $asistioBool = ($asistio == '1' || $asistio === 1);
        }

        $collection->insertOne([
            '_id' => $nextId,
            'id_usuario' => (int)$id_usuario,
            'id_curso' => (int)$id_curso,
            'semana' => $semana,
            'asistio' => (bool)$asistioBool
        ]);

        return true;
    }

    public static function editar($id, $id_usuario, $id_curso, $semana, $asistio)
    {
        global $db;

        $asistioBool = filter_var($asistio, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if ($asistioBool === null) {
            $asistioBool = ($asistio == '1' || $asistio === 1);
        }

        $db->Asistencia->updateOne(
            ['_id' => (int)$id],
            ['$set' => [
                'id_usuario' => (int)$id_usuario,
                'id_curso' => (int)$id_curso,
                'semana' => $semana,
                'asistio' => (bool)$asistioBool
            ]]
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

        $cursor = $db->Asistencia->find();
        $resultado = [];

        foreach ($cursor as $a) {
            $resultado[] = [
                '_id' => (int)$a['_id'],
                'id_usuario' => (int)$a['id_usuario'],
                'id_curso' => (int)$a['id_curso'],
                'semana' => $a['semana'],
                'asistio' => (bool)$a['asistio']
            ];
        }

        return $resultado;
    }

    public static function lista_por_curso_y_semana($id_curso, $semana)
    {
        global $db;

        $cursor = $db->Asistencia->find([
            'id_curso' => (int)$id_curso,
            'semana' => $semana
        ]);

        $resultado = [];
        foreach ($cursor as $a) {
            $resultado[] = [
                '_id' => (int)$a['_id'],
                'id_usuario' => (int)$a['id_usuario'],
                'id_curso' => (int)$a['id_curso'],
                'semana' => $a['semana'],
                'asistio' => (bool)$a['asistio']
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
        '_id' => (int)$doc['_id'],
        'id_usuario' => (int)$doc['id_usuario'],
        'id_curso' => (int)$doc['id_curso'],
        'semana' => $doc['semana'],
        'asistio' => (bool)$doc['asistio']
    ];
}


}
