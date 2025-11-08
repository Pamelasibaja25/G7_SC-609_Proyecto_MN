<?php
require_once '../../config/database.php';

class usuario
{
    public static function inicio($usuario, $password) 
    {
        global $conn;
        session_destroy();

        // Buscar el usuario en la base de datos
        $sql = "SELECT password, id_usuario,nombre,telefono FROM usuario WHERE username = '$usuario'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $password_hash = $row['password'];

            // Verifica si la contraseña ingresada coincide con la almacenada (hash)
            if (password_verify($password, $password_hash)) {
                session_start();
                unset($_SESSION['reportes']);
                unset($_SESSION['reportes-rendimiento']);
                $_SESSION['usuario'] = $row['id_usuario'];
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['telefono'] = $row['telefono'];

                $sql = "SELECT nombre FROM rol WHERE id_usuario = " . $_SESSION['usuario'];
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $rowRol = $result->fetch_assoc();
                    $_SESSION['rol'] = $rowRol['nombre'];
                } else {
                    $_SESSION['rol'] = 'ROLE_USER'; // Por si acaso no encuentra nada
                }

                //Extraer información Estudiante
                $sql = "SELECT id_estudiante, grado,cedula,fecha_nacimiento,encargado_legal,id_escuela FROM estudiante WHERE id_usuario = " . $_SESSION['usuario'];
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $_SESSION['grado'] = $row['grado'];
                    $_SESSION['cedula'] = $row['cedula'];
                    $_SESSION['id_estudiante'] = $row['id_estudiante'];
                    $_SESSION['fecha_nacimiento'] = $row['fecha_nacimiento'];
                    $_SESSION['encargado_legal'] = $row['encargado_legal'];

                    $sql = "SELECT id_escuela,descripcion  FROM escuela where id_escuela = " . $row['id_escuela'];
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $_SESSION['escuela'] = $row['descripcion'];
                    $_SESSION['id_escuela'] = $row['id_escuela'];

                }
                return true; // Inicio de sesión exitoso
            }
        }

        return false; // Usuario no encontrado o contraseña incorrecta
    }

    public static function registro($new_username, $new_password, $new_nombre, $new_cedula, $new_fecha, $new_telefono, $new_encargado, $escuela, $grado)
    {
        global $conn;
        session_destroy();

        // Buscar el usuario en la base de datos
        $sql = "SELECT username FROM usuario WHERE username = '$new_username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return false;
        } else {
            $new_password = password_hash($new_password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO usuario (username,password,nombre, telefono,ruta_imagen,activo) VALUES
            ('$new_username','$new_password','$new_nombre','$new_telefono',NULL,true)";
            $result = $conn->query($sql);

            $sql = "SELECT id_usuario FROM usuario WHERE username = '$new_username'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $new_username = $row['id_usuario'];

            $sql = "INSERT INTO rol (nombre, id_usuario) values
            ('ROLE_USER','$new_username')";
            $result = $conn->query($sql);

            $sql = "INSERT INTO estudiante (id_usuario, cedula,fecha_nacimiento, encargado_legal,grado, id_escuela) VALUES
            ('$new_username','$new_cedula','$new_fecha','$new_encargado','$grado','$escuela')";
            $result = $conn->query($sql);

            return true;
        }
    }

}
?>