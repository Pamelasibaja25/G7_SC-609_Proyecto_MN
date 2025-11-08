<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/config/database.php';

class Escuela
{
    public static function get_escuelas()
    {
        global $db;
        session_start();

        // Obtener la colección "Escuela"
        $collection = $db->Escuela;

        // Buscar todas las escuelas
        $cursor = $collection->find([], [
            'projection' => [
                '_id' => 1,
                'nombre' => 1,
                'provincia' => 1
            ]
        ]);

        // Convertir resultados a un arreglo
        $escuelas = iterator_to_array($cursor);

        return $escuelas;
    }
}
?>
