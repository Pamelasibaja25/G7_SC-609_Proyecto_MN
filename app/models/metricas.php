<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/config/database.php';

class Metricas
{
    // 🔹 Cantidad de usuarios totales
    public static function get_total_usuarios()
    {
        global $db;
        return $db->Usuario->countDocuments();
    }

    // 🔹 Cantidad de estudiantes únicos por nombre o usuario
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

    // 🔹 Cantidad de escuelas
    public static function get_total_escuelas()
    {
        global $db;
        return $db->Escuela->countDocuments();
    }

    // 🔹 Cantidad de cursos totales
    public static function get_total_cursos()
    {
        global $db;
        return $db->Curso->countDocuments();
    }

    // 🔹 Cantidad de profesores
    public static function get_total_profesores()
    {
        global $db;
        return $db->Usuario->countDocuments(['role' => 'profesor']);
    }

    // 🔹 Cantidad de cursos matriculados en el año actual
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

    // 🔹 Cursos por estado (por ejemplo En Progreso / Finalizado)
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
