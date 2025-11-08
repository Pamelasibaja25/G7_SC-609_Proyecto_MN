<?php
require __DIR__ . '/../vendor/autoload.php'; // Carga automática del driver de MongoDB

try {
    $uri = "mongodb+srv://admin:12345@proyectomng7.wwikke6.mongodb.net/Proyecto_MN_G7?retryWrites=true&w=majority";
    $client = new MongoDB\Client($uri);
    $db = $client->selectDatabase('Proyecto_MN_G7');
    echo "Conexión exitosa a MongoDB Atlas";
    
} catch (Exception $e) {
    die("Error al conectar con MongoDB Atlas: " . $e->getMessage());
}
?>
