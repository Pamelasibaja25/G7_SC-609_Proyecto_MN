<?php
require_once __DIR__ . '/../../config/database.php';

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

    public static function editar($id, $nombre, $provincia)
    {
        global $db;

        $db->Escuela->updateOne(
            ['_id' => $id],
            ['$set' => [
                'nombre' => $nombre,
                'provincia' => $provincia
            ]]
        );
    }

    public static function eliminar($id)
    {
        global $db;
        $db->Escuela->deleteOne(['_id' => $id]);
    }
        public static function lista_escuelas()
    {
        global $db;

        $cursor = $db->Escuela->find();
        $resultado = [];

        foreach ($cursor as $p) {
            $resultado[] = [
                '_id' => (int)$p['_id'],
                'nombre' => $p['nombre'],
                'provincia' => $p['provincia']
            ];
        }

        return $resultado;
    }
        public static function registrar($nombre, $provincia)
    {
        global $db;

        $collection = $db->Escuela;

        $last = $collection->findOne([], ['sort' => ['_id' => -1]]);
        $nextId = $last ? ($last['_id'] + 1) : 1;

        $collection->insertOne([
            '_id' => $nextId,
            'nombre' => $nombre,
            'provincia' => $provincia,
        ]);

        return true;
    }
        public static function resumen()
    {
        global $db;

        $cursor = $db->Escuela->aggregate([
            ['$group' => [
                '_id' => '$provincia',
                'total' => ['$sum' => 1]
            ]]
        ]);

        $resultado = [];
        foreach ($cursor as $row) {
            $resultado[$row['_id']] = $row['total'];
        }

        return $resultado;
    }
    
    public static function resumen_escuelas()
{
    global $db;

    $total = $db->Escuela->countDocuments();

    return [
        'total_escuelas' => $total
    ];
}

}
?>
