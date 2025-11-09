<?php
require_once '../models/usuario.php';

try {
    if (!empty($_POST)) {
        $action = $_POST['action'] ?? '';

        if ($action === 'inicio' && !empty($_POST['login-username']) && !empty($_POST['login-password'])) {
            $resultado = usuario::inicio($_POST['login-username'], $_POST['login-password']);
            
            if ($resultado) {
                header("Location: ../../app/views/layout.php?status=success");
                exit();
            } else {
                header("Location: ../../index.php?status=error&msg=Usuario o contraseña incorrecta.");
                exit();
            }
        } 
        else if ($action === 'registro' && !empty($_POST['new-username'])&& !empty($_POST['new-password']) && !empty($_POST['new-nombre'])
        && !empty($_POST['new-cedula']) && !empty($_POST['new-fecha']) && !empty($_POST['new-telefono'])
        && !empty($_POST['escuela']) && !empty($_POST['grado'])) {
            $resultado = usuario::registro($_POST['new-username'], $_POST['new-password'], $_POST['new-nombre'],$_POST['new-cedula'], $_POST['new-fecha'], $_POST['new-telefono'], $_POST['escuela'], $_POST['grado']);
            
            if ($resultado) {
                header("Location: ../../index.php?status=success&msg=Registro exitoso.");
                exit();
            } else {
                header("Location: ../../index.php?status=error&msg=Usuario ya existe en el sistema.");
                exit();
            }
        }
        else {
            header("Location: ../../index.php?status=error&msg=Campos incompletos.");
            exit();
        }
    }
} catch (Exception $e) {
    header("Location: ../../index.php?status=error&msg=" . urlencode($e->getMessage()));
    exit();
}

?>
