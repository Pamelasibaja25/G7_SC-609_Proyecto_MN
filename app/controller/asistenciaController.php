<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/G7_SC-609_Proyecto_MN/app/models/Asistencia.php';

function get_asistencias()
{
    return Asistencia::lista_asistencias();
}

function get_asistencias_por_curso_y_semana($id_curso, $semana)
{
    return Asistencia::lista_por_curso_y_semana($id_curso, $semana);
}

function get_asistencia($id)
{
    return Asistencia::obtener_por_id($id);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'registrar-asistencia') {

        try {
            Asistencia::registrar(
                $_POST['id_usuario'],
                $_POST['id_curso'],
                $_POST['semana'],
                $_POST['asistio']
            );

            header("Location: /G7_SC-609_Proyecto_MN/app/views/asistencia/registro.php?status=success&msg=Asistencia registrada correctamente");
            exit();
        } catch (Exception $e) {
            header("Location: /G7_SC-609_Proyecto_MN/app/views/asistencia/registro.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }

    if ($_POST['action'] === 'editar-asistencia') {

        try {
            Asistencia::editar(
                (int)$_POST['id_asistencia'],
                $_POST['id_usuario'],
                $_POST['id_curso'],
                $_POST['semana'],
                $_POST['asistio']
            );

            header("Location: /G7_SC-609_Proyecto_MN/app/views/asistencia/listado.php?status=success&msg=Asistencia actualizada correctamente");
            exit();
        } catch (Exception $e) {
            header("Location: /G7_SC-609_Proyecto_MN/app/views/asistencia/listado.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }

    if ($_POST['action'] === 'eliminar-asistencia') {

        try {
            Asistencia::eliminar((int)$_POST['id_asistencia']);

            header("Location: /G7_SC-609_Proyecto_MN/app/views/asistencia/listado.php?status=success&msg=Asistencia eliminada correctamente");
            exit();
        } catch (Exception $e) {
            header("Location: /G7_SC-609_Proyecto_MN/app/views/asistencia/listado.php?status=error&msg=" . urlencode($e->getMessage()));
            exit();
        }
    }
}
