<?php
require_once '../../config/database.php';

class Usuario
{

    private static function getNextId($collection)
    {
        $last = $collection->findOne([], [
            'sort' => ['_id' => -1],
            'projection' => ['_id' => 1]
        ]);
        return $last ? (int)$last['_id'] + 1 : 1;
    }

 
    public static function inicio($usuario, $password)
    {
        global $db;
        session_destroy();

        $collectionUsuarios = $db->Usuario;
        $user = $collectionUsuarios->findOne(['username' => $usuario]);

        if ($user) {
            // Verificar contraseña
            if ($user['password'] == $password) {
                session_start();
                $_SESSION['usuario'] = (int)$user['_id'];
                $_SESSION['nombre'] = $user['nombre'] ?? '';
                $_SESSION['telefono'] = $user['telefono'] ?? '';
                $_SESSION['rol'] = $user['role'] ?? 'ROLE_USER';

                $collectionEstudiantes = $db->Estudiante;
                $estudiante = $collectionEstudiantes->findOne(['id_usuario' => (int)$user['_id']]);
                if ($estudiante) {
                    $_SESSION['grado'] = $estudiante['grado'];
                    $_SESSION['cedula'] = $estudiante['cedula'];
                    $_SESSION['id_estudiante'] = (int)$estudiante['_id'];
                    $_SESSION['fecha_nacimiento'] = $estudiante['fecha_nacimiento'];

                    $collectionEscuelas = $db->Escuela;
                    $escuela = $collectionEscuelas->findOne(['_id' => (int)$estudiante['id_escuela']]);
                    if ($escuela) {
                        $_SESSION['escuela'] = $escuela['nombre'] ?? '';
                        $_SESSION['id_escuela'] = (int)$escuela['_id'];
                    }
                }

                return true; // Inicio de sesión exitoso
            }
        }

        return false; // Usuario no encontrado o contraseña incorrecta
    }


    public static function registro($new_username, $new_password, $new_nombre, $new_cedula, $new_fecha, $new_telefono, $escuela, $grado)
    {
        global $db;
        session_destroy();

        $collectionUsuarios = $db->Usuario;
        $collectionEstudiantes = $db->Estudiante;

        $existingUser = $collectionUsuarios->findOne(['username' => $new_username]);
        if ($existingUser) {
            return false;
        }

        $nextUserId = self::getNextId($collectionUsuarios);

        $collectionUsuarios->insertOne([
            '_id' => $nextUserId,
            'username' => $new_username,
            'password' => $new_password,
            'nombre' => $new_nombre,
            'telefono' => $new_telefono,
            'role' => 'user',
            'activo' => true
        ]);

        $nextEstId = self::getNextId($collectionEstudiantes);

        $collectionEstudiantes->insertOne([
            '_id' => $nextEstId,
            'id_usuario' => $nextUserId,
            'cedula' => $new_cedula,
            'fecha_nacimiento' => $new_fecha,
            'grado' => $grado,
            'id_escuela' => (int)$escuela
        ]);

        return true;
    }
}
?>
