<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/models/Profesor.php';

function get_profesores_resumen()
{
    return Profesor::resumen_profesores();
}

function get_especialidades_cursos()
{
    return Profesor::especialidades_cursos();
}

function get_profesores()
{
    return Profesor::lista_profesores();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['action'] === 'registrar-profesor') {

        try{
        Profesor::registrar(
            $_POST['nombre'],
            $_POST['cedula'],
            $_POST['telefono'],
            $_POST['correo'],
            $_POST['especialidad']
        );

        header("Location: /G7_SC-609_Proyecto_MN/app/views/profesor/registro.php?status=success&msg=Profesor registrado correctamente");
        exit();
    }
    catch (Exception $e) {
        header("Location: /G7_SC-609_Proyecto_MN/app/views/profesor/registro.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
    }

    if ($_POST['action'] === 'editar-profesor') {

        try{
        Profesor::editar(
            (int)$_POST['id_profesor'],
            $_POST['nombre'],
            $_POST['cedula'],
            $_POST['telefono'],
            $_POST['correo'],
            $_POST['especialidad']
        );

        header("Location: /G7_SC-609_Proyecto_MN/app/views/profesor/listado.php?status=success&msg=Profesor actualizado correctamente");
        exit();
    }
    catch (Exception $e) {
        header("Location: /G7_SC-609_Proyecto_MN/app/views/profesor/listado.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
    }

    if ($_POST['action'] === 'eliminar-profesor') {

        try{
        Profesor::eliminar((int)$_POST['id_profesor']);

        header("Location: /G7_SC-609_Proyecto_MN/app/views/profesor/listado.php?status=success&msg=Profesor eliminado correctamente");
        exit();
        }
        catch (Exception $e) {
        header("Location: /G7_SC-609_Proyecto_MN/app/views/profesor/listado.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
    }
}
?>
