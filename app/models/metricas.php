<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/config/database.php';

class Metricas
{

    public static function get_total_usuarios()
    {
        global $db;
        return $db->Usuario->countDocuments();
    }

    public static function get_total_estudiantes()
    {
        global $db;

        $estudiantes = $db->Estudiante->aggregate([
            ['$lookup' => [
                'from' => 'Usuario',
                'localField' => 'id_usuario',
                'foreignField' => '_id',
                'as' => 'usuario_info'
            ]],
            ['$unwind' => '$usuario_info'],
            ['$group' => ['_id' => '$usuario_info.nombre']]
        ]);

        return iterator_count($estudiantes);
    }


    public static function get_total_escuelas()
    {
        global $db;
        return $db->Escuela->countDocuments();
    }

 
    public static function get_total_cursos()
    {
        global $db;
        return $db->Curso->countDocuments();
    }


    public static function get_total_profesores()
    {
        global $db;
        return $db->Profesor->countDocuments();
    }


    public static function get_cursos_matriculados_anio()
    {
        global $db;

        $anio = (int)date('Y');
        $inicio = new MongoDB\BSON\UTCDateTime(strtotime("$anio-01-01T00:00:00Z") * 1000);
        $fin = new MongoDB\BSON\UTCDateTime(strtotime(($anio + 1) . "-01-01T00:00:00Z") * 1000);

        return $db->Nota->countDocuments([
            'fecha_inicio' => [
                '$gte' => $inicio,
                '$lt' => $fin
            ]
        ]);
    }


    public static function get_cursos_por_estado()
    {
        global $db;

        $estados = $db->Curso->aggregate([
            ['$group' => ['_id' => '$estado', 'total' => ['$sum' => 1]]]
        ]);

        $resultado = [];
        foreach ($estados as $estado) {
            $resultado[$estado->_id] = $estado->total;
        }

        return $resultado;
    }
}
?>
